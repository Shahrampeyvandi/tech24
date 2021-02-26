<?php

namespace App\Http\Controllers\Home;

use App\Blog;
use App\Post;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        // dd(\Request::getRequestUri());
        if(isset(request()->order)) {
            if(request()->order == 'latest') {
                $order = 'created_at';
            }
            
            elseif(request()->order == 'sell') {
                $order = 'sell_count';
            }
            else{
                abort(404);
            }
        }else{
            $order = 'created_at';
        }
        $data = [
            'webinars' => Post::where('post_type','webinar')->where('start_date','>=' , Carbon::now())->orderBy($order,'DESC')->take(8)->get(),
            'courses' => Post::where('post_type','course')->orderBy($order,'DESC')->take(4)->get(),
            'teachers' => User::role('teacher')->take(4)->get(),
            'blogs' => Blog::latest()->take(3)->get()
        ];

        return view('home.index',$data);
    }
}
