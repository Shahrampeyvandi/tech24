<?php

namespace App\Http\Controllers\Home;

use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function show($slug = null)
    {
        // dd($slug);
        $data['post'] = Post::whereSlug($slug)->first();
        if (!$data['post']) abort(404);
        $data['all_webinars'] = Post::where('post_type', 'webinar')
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
        }elseif(\Request::path() == 'podcasts') {
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
                $q->where('archive',1);
                
            } else {
                $q->where('archive',0)->where('start_date', '>=', Carbon::now());
            }

            $q->where('post_type', $post_type);
        })->orderByDesc($order)->paginate(6);

        $data['page_title'] = $page_title;
        $data['title'] =   $title;
        $data['post_type'] = $post_type;

        $data['latest_posts'] = Post::where('post_type', $post_type)->latest()->take(5)->get();

        if($data['post_type'] == 'podcast') {
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

    public function play(Request $request,$slug=null)
    {
        $data['post'] = Post::whereSlug($slug)->first();
        if (!$data['post']) abort(404);
        // $data['title'] = $request[''];
       
        return view('home.play',$data);
    }
}
