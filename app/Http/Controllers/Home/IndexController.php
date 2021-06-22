<?php

namespace App\Http\Controllers\Home;

use App\Blog;
use App\Post;
use App\Quiz;
use App\User;
use App\Slider;
use Carbon\Carbon;
use App\TokenReset;
use App\Mail\PostRegistered;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Services\HTTPRequest;
use App\Http\Services\AdobeService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class IndexController extends Controller
{
    public function index()
    {

        // dd(Mail::to('yasfuny@gmail.com')->send(new PostRegistered(User::find(6),Post::find(15))));

       

        if (isset(request()->order)) {
            if (request()->order == 'latest') {
                $order = 'created_at';
            } elseif (request()->order == 'sell') {
                $order = 'sell_count';
            } else {
                abort(404);
            }
        } else {
            $order = 'created_at';
        }
        $data = [
            'webinars' => Post::where('post_type', 'webinar')->where('start_date', '>=', Carbon::now())->orderBy($order, 'DESC')->take(8)->get(),
            'courses' => Post::where('post_type', 'course')->where('private', 0)->orderBy($order, 'DESC')->take(8)->get(),
            'teachers' => User::role('teacher')->take(4)->get(),
            'blogs' => Blog::latest()->take(3)->get(),
            'sliders' => Slider::where('active', 1)->latest()->take(4)->get()
        ];

        /* Seo Tools */
        SEOMeta::setTitle('تکوان 24 | آموزش امنیت اطلاعات');
        SEOMeta::setDescription('تکوان 24 , آموزش , امنیت , آموزش برنامه نویسی , جرم شناسی در زمینه امنیت اطلاعات , ...');
        SEOMeta::setCanonical('https://techone24.com');
        OpenGraph::setTitle('تکوان 24 | آموزش امنیت اطلاعات');
        OpenGraph::setDescription('تکوان 24 , آموزش , امنیت , آموزش برنامه نویسی , جرم شناسی در زمینه امنیت اطلاعات , ...');
        OpenGraph::setUrl('https://techone24.com');
        OpenGraph::addImage(asset('assets/imgs/Logo.png'));
        OpenGraph::setType('website');
        TwitterCard::setTitle('تکوان 24 | آموزش امنیت اطلاعات');
        TwitterCard::setDescription('تکوان 24 , آموزش , امنیت , آموزش برنامه نویسی , جرم شناسی در زمینه امنیت اطلاعات , ...');
        TwitterCard::setUrl('https://techone24.com');
        TwitterCard::addImage(asset('assets/imgs/Logo.png'));


        return view('home.index', $data);
    }

    /**
     *
     * about us page
     * @return \Illuminate\Http\Response
     */

    public function aboutus()
    {
        return view('home.aboutus');
    }

    /**
     *
     * contact us page
     * @return \Illuminate\Http\Response
     */

    public function contactus()
    {
        return view('home.contactus');
    }
}
