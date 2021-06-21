<?php

namespace App\Http\Controllers\Home;

use App\Post;
use App\Payment;
use App\AdobeGroup;
use App\AdobeUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Toastr;

class PayController extends Controller
{
    public function pay(Request $request)
    {

        $post = Post::findOrFail($request->id);


        // $expire_date = Carbon::now()->addDays($post->days);

        //برای تست کردن مقدار دیباگ مد رو روی یک قررا بده وگرنه صفر
        $debugmode = 1;

        $user = auth()->user();

        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->post_id = $post->id;


        $payment->amount =  $post->price;
        $payment->save();





        $data = array(
            'MerchantID' => '2a00b862-a97e-11e6-9e29-005056a205be',
            'Amount' => $payment->amount,
            'CallbackURL' => route('pay.callback') . '?id=' . $payment->id,
            'Description' => 'پرداخت از سایت'
        );
        
        $jsonData = json_encode($data);
        if ($debugmode == 1) {
            $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        } else {
            $ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if ($result["Status"] == 100) {

                if ($debugmode == 1) {
                    $link = 'https://sandbox.zarinpal.com/pg/StartPay/' . $result["Authority"];
                } else {
                    $link = 'https://www.zarinpal.com/pg/StartPay/' . $result["Authority"];
                }

                return redirect($link);


                die();
            } else {
                echo 'ERR: ' . $result["Status"];
            }
        }
    }

    public function callback(Request $request)
    {
        $user = auth()->user();
        //برای تست کردن مقدار دیباگ مد رو روی یک قررا بده وگرنه صفر
        $debugmode = 1;

        $payment = Payment::find($request->id);

        $Authority = $request->Authority;

        $data = array('MerchantID' => '2a00b862-a97e-11e6-9e29-005056a205be', 'Authority' => $Authority, 'Amount' => $payment->amount);
        $jsonData = json_encode($data);
        if ($debugmode == 1) {
            $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        } else {
            $ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        }

        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if ($result['Status'] == 100) {
                //echo 'Transation success. RefID:' . $result['RefID'];

                $payment->success = 1;
                $payment->transaction_code = $result['RefID'];
                $payment->update();

                $post = Post::find($payment->post_id);
                if (!$post) abort(404);
                // getCurrentUser()->posts()->attach($post->id);

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
                return redirect()->route('member.posts', ['user'=>getCurrentUser()->username,'post_type' => $post->post_type]);
            } else {

                // تراکنش ناموفق بوده
                // toastr()->error('تراکنش ناموفق بود');
                return back();
            }
        }
    }
}
