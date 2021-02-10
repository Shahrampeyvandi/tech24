<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Question;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuizController extends Controller
{

    public $title = 'آزمون';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'quizzes' => Quiz::latest()->get(),
            'title' => $this->title
        ];
        return view('admin.course.quizzes',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->title;
        return view('admin.course.create-quiz',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->action)){
            $q = Quiz::find($request->quiz_id);
        }else{

            $q = new Quiz();
        }
        // dd($request->q);
        $q->title = $request->q_name;
        $q->countdown = $request->q_countdown;
        $q->save();

        foreach ($request->q as $key => $item) {
            // dd($item);
            if(array_key_exists('id',$item)){
                $question = Question::find($item['id']);
            }else{
                $question = new Question();
            }

            $question->title = $item['title'];
            $question->option_one = $item['option_one'];
            $question->option_two = $item['option_two'];
            $question->option_three = $item['option_three'];
            $question->option_four = $item['option_four'];
            // $question->option_five = $item['option_five'];
            $question->point = '10';
            $question->answer = $item['answer'];
            $question->quiz_id = $q->id;
            $question->save();
        }

        return Redirect::route('quizzes.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['quiz'] = Quiz::find($id);
        return view('admin.course.create-quiz',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $quiz = Quiz::find($id);
        // dd($quiz);
        $quiz->questions()->delete();
        $quiz->delete();
        return Redirect::back();
    }
}
