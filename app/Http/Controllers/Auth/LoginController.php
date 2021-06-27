<?php

namespace App\Http\Controllers\Auth;

use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {



        $request->validate([
            'g-recaptcha-response' => ['required', new Recaptcha()],
            'username' => 'required|string',
            'password' => 'required',
        ]);


        if ($this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        )) {
            return response()->json([
                'auth' => auth()->check(),
                // 'user' => $user,
                'redirect' => auth()->user()->hasRole('admin') ?
                    route('admin.index') : (request()->query('afterLogin') ?  request()->query('afterLogin') : route('member.dashboard', ['user' => auth()->user()->username]))

            ]);
        }

        throw ValidationException::withMessages(['message' => 'اطلاعات وارد شده اشتباه است']);
    }
    public function logout()
    {

        Auth::logout();
        return redirect('/');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {


        return response()->json([
            'auth' => auth()->check(),
            // 'user' => $user,
            'redirect' => $user->hasRole('admin') ?
                route('admin.index') : route('member.dashboard', ['user' => $user->username])

        ]);
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('username'))) {
            return ['mobile' => $request->get('username'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('username'), 'password' => $request->get('password')];
        }
        return ['username' => $request->get('username'), 'password' => $request->get('password')];
    }

    /**
     * return username 
     *
     * @return void
     */
    public function username()
    {
        if (filter_var(request('username'), FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        return 'mobile';
    }
}
