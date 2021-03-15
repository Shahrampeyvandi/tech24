<?php

namespace App\Http\Controllers\Panel;

use App\Post;
use App\User;
use App\Answer;
use App\Lesson;
use App\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Passed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class CourseController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_quiz($user, $lessonId)
    {
        // dd($user,$lessonId);


        $data['lesson'] = Lesson::findOrFail($lessonId);
        $post = $data['lesson']->post;
        if (!$post || !getCurrentUser()->posts->contains($post->id)) abort(403);

        $data['quiz'] = $data['lesson']->quiz;

        $data['user'] = User::where('username', $user)->firstOrFail();
        // if(! $data['user']->lessons->contains($id)) abort(403);
        $data['title'] =  $data['lesson']->title;

        return view('panel.show-quiz', $data);
    }
    /**
     * Start Quiz Lesson.
     *
     * @param  string  $user 
     * @param id $lessonId
     * @return \Illuminate\Http\Response
     */
    public function start_quiz($user, $lessonId)
    {
        // dd(session()->get('old-questions'));

        $data['lesson'] = Lesson::findOrFail($lessonId);


        $post = $data['lesson']->post;


        if (!$post || !getCurrentUser()->posts->contains($post->id)) abort(403);

        $data['quiz'] = $data['lesson']->quiz;

        if ($data['quiz'] && Passed::where('quiz_id', $data['quiz']->id)->where('user_id', getCurrentUser()->id)->first()) {
            return Redirect::route('member.posts', getCurrentUser()->username);
        }


        $seconds = explode(':', $data['quiz']->countdown)[2];
        $minutes = explode(':', $data['quiz']->countdown)[1];
        $now = time();
        $end = $now + ($minutes * 60) + $seconds;

        session()->put('start', date('m-d-Y H:i:s', $now));
        session()->put('end', date('m-d-Y H:i:s', $end));

        session()->put('correct-answers', 0);
        session()->put('incorrect-answers', 0);
        session()->forget('questions-count');


        $data['user'] = User::where('username', $user)->firstOrFail();
        // if(! $data['user']->lessons->contains($id)) abort(403);
        $data['title'] =  $data['lesson']->title;

        $data['question'] = $data['quiz']->questions()->inRandomOrder()->first();
        session()->put('old-questions', [$data['question']->id]);

        session()->put('starttime', Carbon::now());

        return view('panel.start-quiz', $data);
    }

    public function submit_answer(Request $request)
    {

        // dd(getCurrentUser()->id);
        // dd($request->all());
        $question = Question::findOrFail($request->question);
        $quiz = $question->quiz;
        if (strtotime(session()->get('end')) > strtotime(date('m-d-Y H:i:s', time()))) {

            $answer = Answer::where(['question_id' => $question->id, 'user_id' => getCurrentUser()->id])->first();
            if (!$answer) {
                $answer = new Answer;
                $answer->user_id = getCurrentUser()->id;
                $answer->question_id = $question->id;
            }

            $answer->answer = $request->answer;
            $answer->save();

            if ($answer->answer == $question->answer) {
                session()->increment('correct-answers');
            } else {
                session()->increment('incorrect-answers');
            }

            // dd(session()->get('correct-answers') ,session()->get('incorrect-answers'));


            session()->increment('questions-count');

            if ($quiz->questionscount == session()->get('questions-count')) {
                if (session()->get('correct-answers') > session()->get('incorrect-answers')) {
                    $pass = new Passed;
                    $pass->correct_answers = session()->get('correct-answers');
                    $pass->incorrect_answers = session()->get('incorrect-answers');
                    $pass->quiz_id = $quiz->id;
                    $pass->user_id = getCurrentUser()->id;
                    $pass->save();

                    return Response::json([
                        'timeover' => false,
                        'success' => 'true',
                        'message' => 'تبریک ! شما در آزمون قبول شدید',
                        'question' => null,
                        'ended' => true,
                        'url' => route('member.course.lessons', ['user' => getCurrentUser()->id, 'id' => $quiz->quizable->id])
                    ], 200);
                }
                return Response::json([
                    'timeover' => false,
                    'success' => 'false',
                    'message' => 'متاسفانه شما نتوانستید در آزمون قبول شوید :/',
                    'question' => null,
                    'ended' => true,
                    'url' => route('member.course.lessons', ['user' => getCurrentUser()->id, 'id' => $quiz->quizable->id])
                ], 200);
            }






            $randomQuestion = $quiz->questions()->whereNotIn('id', session()->get('old-questions'))->inRandomOrder()->first();

            session()->push('old-questions', $question->id);
            // dd(session()->get('old-questions'));

            return Response::json(['timeover' => false, 'success' => 'false',  'score' => 20, 'question' => $randomQuestion], 200);
        } else {
            return Response::json([
                'timeover' => true,
                'success' => 'false',
                'message' => 'متاسفانه شما نتوانستید در آزمون قبول شوید :/',
                'score' => 20,
                'question' => null,
                'url' => route('member.course.lessons', ['user' => getCurrentUser()->id, 'id' => $quiz->quizable->id])
            ], 200);
        }
    }
}
