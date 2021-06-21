<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function Callback($provider)
    {
        try {
            $userSocial =   Socialite::driver($provider)->stateless()->user();
         
            $user  =   User::where(['email' => $userSocial->getEmail()])->first();
            if ($user) {
                Auth::login($user);
                if($user->hasRole('admin')){
                    return redirect(RouteServiceProvider::ADMIN);
                }
                return redirect()->route('member.dashboard',['user'=>$user->username]);
            } else {
                $user = User::create([
                    'fname'          => explode(' ',$userSocial->getName())[0] ?? "",
                    'lname'         => explode(' ',$userSocial->getName())[1] ?? "",
                    'username'         => randomUserName(explode(' ',$userSocial->getName())[0],explode(' ',$userSocial->getName())[1]) ?? Str::random(8),
                    'email' => $userSocial->getEmail()
                    
                ]);
                
                Auth::login($user);

                $notification = new Notification;
                $notification->title = 'تکمیل اطلاعات شخصی';
                $notification->text = "کاربر عزیز \n لطفا جهت تکمیل اطلاعات فردی خود به قسمت <a href='/panel/{$user->username}/profile'>ویرایش اطلاعات</a> مراجعه نمایید";
                $notification->user_id = $user->id;
                $notification->save();



                return redirect()->route('member.dashboard',['user'=>$user->username]);


            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}
