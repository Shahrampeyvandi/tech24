<?php

namespace App\Http\Controllers\Auth;

use Toastr;
use App\User;
use Carbon\Carbon;
use App\TokenReset;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {

        $request->validate($this->rules());

        $passreset = TokenReset::where('mobile', $request->mobile)->where('code', $request->code)->where('updated_at', '>=', Carbon::now()->subMinutes(5))->first();
        // dd($passreset, is_null($passreset));
        if (is_null($passreset)) {

            Toastr::info('کد ارسالی شما نامعتبر میباشد لطفا مجددا سعی کنید', ' پیغام');
            return Redirect::route('password.request');
        }


        $user = User::whereMobile($request->mobile)->first();
        if ($user) {
            $user->password = $request->password;
            $user->save();

            $notification = new Notification;
            $notification->title = 'تغییر رمز عبور';
            $notification->text = "کاربر عزیز \n رمز عبور شما با موفقیت تغییر کرد";
            $notification->save();

            Toastr::success('رمز عبور شما با موفقیت تغییر کرد', ' پیغام');
            return Redirect::route('login');
        }


        return Redirect::to($this->redirectPath());
    }
}
