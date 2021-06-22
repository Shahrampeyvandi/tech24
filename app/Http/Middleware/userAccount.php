<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Toastr;

class userAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->mobile && Auth::user()->email && Auth::user()->mobile_verified) {

            return $next($request);
        }
        Toastr::error("کاربر گرامی قبل از ثبت نام لازم است مشخصات خود را تکمیل کنید");
        return redirect()->route('member.profile',['user'=>Auth::user()->username]);
    }
}