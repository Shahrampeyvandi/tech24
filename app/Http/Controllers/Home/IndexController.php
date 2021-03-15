<?php

namespace App\Http\Controllers\Home;

use App\Blog;
use App\Post;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Slider;
use App\User;
use Carbon\Carbon;
use Soheilrt\AdobeConnectClient\Facades\Client;


class IndexController extends Controller
{
    public function index()
    {

     
        // $ch = curl_init('http://online.techone24.com/api/xml?action=login&login=test@gmail.com&password=123456');
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch,CURLOPT_COOKIEFILE, __DIR__.'/cookies');
        // curl_setopt($ch,CURLOPT_COOKIEJAR, __DIR__.'/cookies');
        // $data = curl_exec($ch);
        // // dd($data);
        // curl_close($ch);
        // Query.
// $ch = curl_init('http://online.techone24.com/api/xml?action=principal-list&filter-type=group');
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch,CURLOPT_COOKIEFILE, __DIR__.'/cookies');
// curl_setopt($ch,CURLOPT_COOKIEJAR, __DIR__.'/cookies');
// $data = curl_exec($ch);
// var_dump($data);
// curl_close($ch);

// Query.
// $ch = curl_init('http://online.techone24.com/api/xml?action=principal-update&first-name=tests&last-name=tesss&has-children=0&login=test@example.com&type=user');
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch,CURLOPT_COOKIEFILE, __DIR__.'/cookies');
// curl_setopt($ch,CURLOPT_COOKIEJAR, __DIR__.'/cookies');
// $data = curl_exec($ch);
// var_dump($data);
// curl_close($ch);

// Query.
// $ch = curl_init('http://online.techone24.com/api/xml?action=principal-update&has-children=1&type=group&name=testwithcurl');
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch,CURLOPT_COOKIEFILE, __DIR__.'/cookies');
// curl_setopt($ch,CURLOPT_COOKIEJAR, __DIR__.'/cookies');
// $data = curl_exec($ch);
// var_dump($data);
// curl_close($ch);

// $ch = curl_init('http://online.techone24.com/api/xml?action=group-membership-update&group-id=51275&principal-id=49195&is-member=1');
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch,CURLOPT_COOKIEFILE, __DIR__.'/cookies');
// curl_setopt($ch,CURLOPT_COOKIEJAR, __DIR__.'/cookies');
// $data = curl_exec($ch);
// var_dump($data);
// curl_close($ch);
   
        // dd(public_path());
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
            'blogs' => Blog::latest()->take(3)->get(),
            'sliders' => Slider::where('active',1)->latest()->take(4)->get()
        ];
       

        return view('home.index',$data);
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
