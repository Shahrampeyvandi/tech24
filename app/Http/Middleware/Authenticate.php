<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Toastr;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            Toastr::info("کاربر گرامی ابتدا وارد حساب کاربری خود شوید");
            return url('/') . "?afterLogin=" . url()->previous();
        }
    }
}
