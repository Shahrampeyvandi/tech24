<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use App\TokenReset;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Rules\ExistCode;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Toastr;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);

        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u'],
            'lname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['required', 'unique:users', 'string', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u','min:5', 'max:15'],
            'mobile' => ['required', 'regex:/(09)[0-9]{9}/', 'unique:users'],
            'code' => ['required',new ExistCode($data)]

        ],[
            'fname.regex' => 'نام شما باید تنها شامل حروف لاتین باشد',
            'lname.regex' => 'نام خانوادگی شما باید تنها شامل حروف لاتین باشد',
            'code' => 'کد ارسالی شما مطابقت ندارد لطفا لحظاتی دیگر مجددا تلاش کنید'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
//         dd($data);
        // $passreset = TokenReset::where('mobile', $data['mobile'])->where('code', $data['code'])->where('updated_at', '>=', Carbon::now()->subMinutes(5))->first();
        // // dd($passreset, is_null($passreset));
        // if (is_null($passreset)) {

        //     Toastr::info('کد ارسالی شما نامعتبر میباشد لطفا مجددا سعی کنید', ' پیغام');
        //     return Redirect::route('register');
        // }
        return User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'username' => $data['username'],
            'mobile' => $data['mobile'],
        ]);
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user) :void
    {
        $user->syncRoles(['student']);


        $notification = new Notification;
        $notification->title = 'به تکوان خوش آمدید';
        $notification->text = "کاربر عزیز \n ورورد شما را به سایت آموزشی تکوان تبریک میگوییم";
        $notification->user_id = $user->id;
        $notification->save();

            //------ ارسال پیامک ثبت نام کاربر جدید
            $patterncode = "4ex85b2su5";
            $data = array("name" => $user->username);
            $this->sendSMS($patterncode, $user->mobile, $data);
    }

    public function checkMobile(Request $request): \Illuminate\Http\JsonResponse
    {
        // dd($request->post());
        $patterncode  = '6onq2eu1g2';
        // validate mobile
        $request->validate([
            'mobile' => 'required|unique:users|regex:/(09)[0-9]{9}/'
        ]);

        $passreset = TokenReset::where('mobile',$request->mobile)->where('updated_at', '>', Carbon::now()->subMinutes(2))->first();

        if($passreset) {
            return Response::json(['status'=>false,'errors'=>['لطفا دقایقی دیگر دوباره تلاش کنید']],422);
        }
        $passreset = TokenReset::firstOrCreate(['mobile'=>$request->mobile],['code'=>mt_rand(100000, 999999)]);
//        $passreset->code = mt_rand(100000, 999999);
        $passreset->updated_at = Carbon::now();
        $passreset->save();


        // send sms
        $this->sendSMS($patterncode,$request->mobile,array('code'=>strval($passreset->code)));

        // return success
        return Response::json(['success'=>true,'timer'=>date('Y/m/d H:i:s',strtotime('00:02:00'))],200);
    }
}
