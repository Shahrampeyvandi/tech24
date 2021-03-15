<?php

namespace App\Http\Controllers\Home;

use App\AdobeGroup;
use App\AdobeUsers;
use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Toastr;

class PostController extends Controller
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
        if (\Request::path() == 'courses') {
            $page_title =  'تکوان | دوره ها';
            $title = 'دوره';
            $post_type = 'course';
        } elseif (\Request::path() == 'podcasts') {
            $page_title =  'تکوان | پادکست ها';
            $title = 'پادکست';
            $post_type = 'podcast';
        } else {
            $page_title =  'تکوان | وبینار ها';
            $post_type = 'webinar';
            $title = isset($request->q) && $request->q == 'archive' ? 'وبینارهای گذشته' : 'وبینار';
        }


        $order = isset($request->order) ? $request->order : 'created_at';
        $data['posts'] = Post::where(function ($q) use ($category, $post_type, $request) {

            if ($category) {
                $q->whereHas('category', function ($q) use ($category, $post_type) {
                    $q->whereSlug($category);
                });
            }



            if ($post_type == 'webinar' && isset($request->q) && $request->q == 'archive') {
                $q->where('archive', 1);
            } elseif ($post_type == 'podcast') {
            } else {
                $q->where('archive', 0)->where('start_date', '>=', Carbon::now());
            }

            $q->where('post_type', $post_type);
        })->orderByDesc($order)->paginate(6);
        // dd($data);

        $data['page_title'] = $page_title;
        $data['title'] =   $title;
        $data['post_type'] = $post_type;

        $data['latest_posts'] = Post::where('post_type', $post_type)->latest()->take(5)->get();

        if ($data['post_type'] == 'podcast') {
            return view('home.podcasts', $data);
        }
        return view('home.posts', $data);
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
            if ($lesson->quiz) {
                // check if user can view lesson
                if (!Auth::user()->posts->contains($post->id)) abort(403);
                // if($lesson->number !== 1) {
                //    if($lesson->)
                // }
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
       

        if(getCurrentUser()->posts->contains($post->id)) {
            
            Toastr::info('ثبت نام مجدد امکان پذیر نمیباشد', ' پیغام');
            return Redirect::route('post.show',$post->slug);
        }




        getCurrentUser()->posts()->attach($post->id);

        if ($post->post_type == 'webinar') {
            $name = 'وبینار';
            $response =  $this->create_user_in_adobe();
            // dd($response);
            if (is_array($response) && $response['status']['@attributes']['code'] == 'ok') {
                $userobj = new AdobeUsers;
                $userobj->principal_id = $response['principal']['@attributes']['principal-id'];
                $userobj->account_id = $response['principal']['@attributes']['account-id'];
                $userobj->user_id = getCurrentUser()->id;
                $userobj->save();

                $group = AdobeGroup::where('post_id', $post->id)->first();
                if ($group) {
                    $res = $this->add_user_to_adobegroup($userobj->principal_id, $group->principal_id);
                    if ($res['status']['@attributes']['code'] == 'ok') {
                        $group->users()->attach($userobj->id);
                    }
                }
            }else{
                Toastr::info('ثبت نام شما در وبینار انجام شد اما خطایی در وارد کردن اطلاعات شما رخ داد !', ' پیغام');
                return Redirect::route('post.show',$post->slug);

            }
        }else{
            $name = 'دوره';
        }
        Toastr::success('شما برای همیشه با این '.$name.' دسترسی دارید', 'موفق ');
        return Redirect::route('member.posts', ['user' => getCurrentUser()->username, 'post_type' => $post->post_type]);
    }

    protected function add_user_to_adobegroup($user_id, $group_id)
    {

        try {
            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=login&login=' . env('ADOBE_CONNECT_USER_NAME') . '&password=' . env('ADOBE_CONNECT_PASSWORD') . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init('http://online.techone24.com/api/xml?action=group-membership-update&group-id=' . $group_id . '&principal-id=' . $user_id . '&is-member=1');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);
            return $arr = json_decode(json_encode(simplexml_load_string($data)), true);
        } catch (\Exception $th) {
            throw $th;
        }
    }
    protected function create_user_in_adobe()
    {

        try {
            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=login&login=' . env('ADOBE_CONNECT_USER_NAME') . '&password=' . env('ADOBE_CONNECT_PASSWORD') . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init('http://online.techone24.com/api/xml?action=principal-update&first-name=' . str_replace(' ', '', getCurrentUser()->fname) . '&last-name=' . str_replace(' ', '', getCurrentUser()->lname) . '&has-children=0&login=' . getCurrentUser()->email . '&type=user');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);
            
            return $arr = json_decode(json_encode(simplexml_load_string($data)), true);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
