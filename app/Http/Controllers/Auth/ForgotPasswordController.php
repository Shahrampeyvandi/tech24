<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TokenReset;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Redirect;
use Toastr;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

     /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgotpass');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        
        

        $this->validateEmail($request);

        if(! User::whereMobile($request->mobile)->count()) {
            Toastr::info('کاربری با این شماره تلفن یافت نشد', ' پیغام');
            return Redirect::back();
        }

        $passreset = TokenReset::where('mobile',$request->mobile)->first();
        if($passreset) {
        }else{
            $passreset = new TokenReset;
            $passreset->mobile = $request->mobile;
            
        }
        $passreset->code = mt_rand(100000, 999999);
        $passreset->save();
   

       


        $data = array('code'=>$passreset->code);

        $this->sendSMS('zepths4ghz',$request->mobile,$data);

        return Redirect::route('password.sendcode',['mobile'=>$request->mobile]);


    }


    public function SendCode()
    {
        // dd(request()->mobile);
        return view('auth.confirm-reset',['mobile'=>request()->mobile]);
    }

}
