<?php

namespace App\Http\Controllers\Home;

use App\Blog;
use App\Post;
use App\Quiz;
use App\User;
use App\Slider;
use Carbon\Carbon;
use App\TokenReset;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;


class IndexController extends Controller
{
    public function index()
    {
        // $patterncode = '6onq2eu1g2';
        // // validate mobile
        // // $request->validate([
        // //     'mobile' => 'required|regex:/(09)[0-9]{9}/'
        // // ]);

        // $passreset = TokenReset::where('mobile','09911041242')->first();
        // if($passreset) {
        // }else{
        //     $passreset = new TokenReset;
        //     $passreset->mobile = '09911041242';
            
        // }
        // $passreset->code = mt_rand(100000, 999999);
        // $passreset->save();


        // // send sms 
        // $this->sendSMS($patterncode,'09911041242',array('code'=>strval($passreset->code)));

        // dd(date('Y/m/d H:i:s',strtotime('00:02:00')));
        //    $user =  User::find(1);
        //     $user->syncRoles(['admin']);
        //     dd('d');

        // $conn = ftp_connect(env('FTP_HOST'));
        // dd($login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD')));
        // ftp_set_option($conn, FTP_USEPASVADDRESS, false);
        // ftp_pasv($conn, true);

        // try {

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


        // $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=sco-info&sco-id=50422');
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
        // curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
        // $data = curl_exec($ch);
        // // echo '<pre>';
        // // var_dump($data);
        // // echo '</pre>';
        // return json_decode(json_encode(simplexml_load_string($data)), true)['sco']['url-path'];
        // } catch (\Throwable $th) {
        //   return $th->getMessage();
        // }


        // curl_close($ch);



        // dd(public_path());
        // dd(\Request::getRequestUri());


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
            'courses' => Post::where('post_type', 'course')->where('private',0)->orderBy($order, 'DESC')->take(8)->get(),
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
