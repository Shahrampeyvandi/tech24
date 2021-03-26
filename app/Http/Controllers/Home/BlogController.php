<?php

namespace App\Http\Controllers\Home;

use App\AdobeGroup;
use App\AdobeUsers;
use App\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Toastr;

class BlogController extends Controller
{
    public function show($slug = null)
    {
        // dd($slug);
        $data['post'] = Post::whereSlug($slug)->first();
        if (!$data['post']) abort(404);
        $data['related_posts'] = Post::where('post_type', $data['post']->post_type)
            ->where('start_date', '>=', Carbon::now())
            ->where('id', '!=', $data['post']->id)
            ->latest()->take(8)->get();

        $data['title'] = 'تکوان | ' . $data['post']->title;

        return view('home.' . $data['post']->post_type, $data);
    }

    public function posts(Request $request, $category = null)
    {
        
            $page_title =  'تکوان | وبلاگ ها';
           


        $order = isset($request->order) ? $request->order : 'created_at';
        $data['blogs'] = Blog::where(function ($q)  {

        })->orderByDesc($order)->paginate(6);
        
        $data['page_title'] = $page_title;
        $data['title'] =   'وبلاگ';
        
        
        $data['latest_blogs'] = Blog::latest()->take(5)->get();
        $data['post_type'] = 'blog';
        // dd($data);

        return view('home.blogs', $data);
    }
    public function courses(Request $request)
    {
        // dd($request->url());
    }
    public function podcasts(Request $request)
    {
        // dd($request->url());
        $data['title'] =   $title;
        return view('home.posts', $data);
    }

    public function play(Request $request, $slug = null)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        // $data['title'] = $request[''];

        if (isset($request->lesson) && $request->lesson) {
            $lesson = Lesson::findOrFail($request->lesson);
            if (getCurrentUser()->hasRole('admin')) {
            } else {

                if ($lesson->quiz) {
                    // check if user can view lesson
                    if (!Auth::user()->posts->contains($post->id)) abort(403);
                    // if($lesson->number !== 1) {
                    //    if($lesson->)
                    // }
                }
            }
            $data['url'] = $lesson->files->first()->file;
            $data['title'] = $lesson->title;
        } else {
            $data['url'] = $post->files->first()->file;
            $data['title'] = $post->title;
        }

        return view('home.play', $data);
    }

    public function register($slug)
    {
        // dd(getCurrentUser());

        $post = Post::whereSlug($slug)->first();
        if (!$post) abort(404);


        if (getCurrentUser()->posts->contains($post->id)) {

            Toastr::info('ثبت نام مجدد امکان پذیر نمیباشد', ' پیغام');
            return Redirect::route('post.show', $post->slug);
        }





        if ($post->post_type == 'webinar') {
            $name = 'وبینار';

            if (!AdobeUsers::where('user_id', getCurrentUser()->id)->first()) {
                $response =  $this->create_user_in_adobe();
                if (is_array($response) && $response['status']['@attributes']['code'] == 'ok') {
                    $userobj = new AdobeUsers;
                    $userobj->principal_id = $response['principal']['@attributes']['principal-id'];
                    $userobj->account_id = $response['principal']['@attributes']['account-id'];
                    $userobj->user_id = getCurrentUser()->id;
                    $userobj->save();
                } else {
                    Toastr::info('خطایی در روند ثبت نام رخ داد!', ' پیغام');
                    return Redirect::route('post.show', $post->slug);
                }
            } else {
                $userobj = AdobeUsers::where('user_id', getCurrentUser()->id)->first();
            }

            // dd($response);


            $group = AdobeGroup::where('post_id', $post->id)->first();
            if ($group) {
                $res = $this->add_user_to_adobegroup($userobj->principal_id, $group->principal_id);
                if ($res['status']['@attributes']['code'] == 'ok') {
                    $group->users()->attach($userobj->id);
                    getCurrentUser()->posts()->attach($post->id);


                    //------ ارسال پیامک ثبت نام در وبینار
                    $patterncode = "q9uaxab7bs";
                    $data = array("name" => getCurrentUser()->username, 'post-title' => $post->title);
                    $this->sendSMS($patterncode, getCurrentUser()->mobile, $data);
                    
                } else {
                }
            }
        } else {
            $name = 'دوره';

            getCurrentUser()->posts()->attach($post->id);

            //------ ارسال پیامک ثبت نام در دوره
            $patterncode = "ts5qit1pfb";
            $data = array("name" => getCurrentUser()->username, 'post-title' => $post->title);
            $this->sendSMS($patterncode, getCurrentUser()->mobile, $data);
        }

        Toastr::success('شما برای همیشه با این ' . $name . ' دسترسی دارید', 'موفق ');
        return Redirect::route('member.posts', ['user' => getCurrentUser()->username, 'post_type' => $post->post_type]);
    }

   
}
