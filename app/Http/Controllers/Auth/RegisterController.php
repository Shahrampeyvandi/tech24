<?php

namespace App\Http\Controllers\Auth;

use Toastr;
use App\User;
use Carbon\Carbon;
use App\TokenReset;
use App\Notification;
use App\Rules\ExistCode;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;

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
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $data['username'];
            $data['mobile'] = "";
        } else {
            $data['mobile'] = $data['username'];
            $data['email'] = "";
        }

        return Validator::make($data, [
            'firstName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u'],
            'lastName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u'],
            'email' => [
                'string',
                //  'email',
                'max:255', 'unique:users'
            ],
            'password' => [
                'required', 'string', 'min:8',
                //  'confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'
            ],
            // 'username' => ['required', 'unique:users', 'string', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u','min:5', 'max:15'],
            'mobile' => ['regex:/(09)[0-9]{9}/', 'unique:users'],
            'activationCode' => [
                'required',
                // new ExistCode($data)
            ]

        ], [

            'firstName.regex' => 'نام شما باید تنها شامل حروف لاتین باشد',
            'lastName.regex' => 'نام خانوادگی شما باید تنها شامل حروف لاتین باشد',
            'activationCode' => 'کد ارسالی شما مطابقت ندارد لطفا لحظاتی دیگر مجددا تلاش کنید',
            'password.regex' => 'رمز عبور باستی حداقل 8 کاراکتر و شامل حداقل یک حرف کوچک یک حرف بزرگ و یک عدد و یک کاراکتر خاص باشد',
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
            'fname' => $data['firstName'],
            'lname' => $data['lastName'],
            'email' => $data['email'] ?? '',
            'password' => $data['password'],
            'username' => $data['username'] ?? "choose",
            'mobile' => $data['mobile'] ?? '',
        ]);
    }



    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {

        if ($request->ajax()) {

            return response()->json([
                'auth' => auth()->check(),
                'user' => $user,
                'redirect' => '/',
            ]);
        }
        // $user->syncRoles(['student']);


        // $notification = new Notification;
        // $notification->title = 'به تکوان خوش آمدید';
        // $notification->text = "کاربر عزیز \n ورورد شما را به سایت آموزشی تکوان تبریک میگوییم";
        // $notification->user_id = $user->id;
        // $notification->save();

        //     //------ ارسال پیامک ثبت نام کاربر جدید
        //     $patterncode = "4ex85b2su5";
        //     $data = array("name" => $user->username);
        //     $this->sendSMS($patterncode, $user->mobile, $data);
    }

    public function checkMobile(Request $request): \Illuminate\Http\JsonResponse
    {
        $patterncode  = '6onq2eu1g2';
        // validate mobile
        $request->validate([
            'mobile' => 'required|unique:users|regex:/(09)[0-9]{9}/'
        ]);

        $passreset = TokenReset::where('mobile', $request->mobile)->where('updated_at', '>', Carbon::now()->subMinutes(2))->first();

        if ($passreset) {
            return Response::json(['status' => false, 'errors' => ['message' => ['لطفا دقایقی دیگر دوباره تلاش کنید']]], 422);
        }
        $passreset = TokenReset::firstOrCreate(['mobile' => $request->mobile], ['code' => mt_rand(100000, 999999)]);
        //        $passreset->code = mt_rand(100000, 999999);
        $passreset->updated_at = Carbon::now();
        $passreset->save();


        // send sms
        $this->sendSMS($patterncode, $request->mobile, array('code' => strval($passreset->code)));

        // return success
        return Response::json([
            'success' => true,
            // 'code' => $passreset->code,
            'timer' => date('Y/m/d H:i:s', strtotime('00:02:00'))
        ], 200);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new Recaptcha()],
            'firstName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z]*$/u'],
            'lastName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z]*$/u'],
            'email' => [
                'nullable',
                'email',
                'max:255', 'unique:users'
            ],
            'password' => [
                'required', 'string', 'min:8',
                //  'confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'
            ],
            'uniqueName' => ['required', 'unique:users,username', 'string', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u', 'min:6', 'max:15'],
            'mobile' => [
                'regex:/(09)[0-9]{9}/', 'nullable', 'unique:users'
            ],
            'activationCode' => ['required', new ExistCode($request->all())],

        ], [
            'uniqueName' => "نام کاربری باید شامل حروف کوچک , بزرگ و کاراکترهای خاص باشد",
            'firstName' => 'نام شما باید تنها شامل حروف لاتین باشد',
            'lastName' => 'نام خانوادگی شما باید تنها شامل حروف لاتین باشد',
            'activationCode' => 'کد ارسالی شما مطابقت ندارد لطفا لحظاتی دیگر مجددا تلاش کنید',
            'password' => 'رمز عبور باستی حداقل 8 کاراکتر و شامل حداقل یک حرف کوچک یک حرف بزرگ و یک عدد و یک کاراکتر خاص باشد',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $user = User::create([
            'fname' => $request['firstName'],
            'lname' => $request['lastName'],
            'email' => $request['email'] ?? null,
            'password' => $request['password'],
            'username' => $request['uniqueName'],
            'mobile' => $request['mobile'],
            'mobile_verified' => 1
        ]);

        Auth::login($user);

        $notification = new Notification;
        $notification->title = 'به تکوان خوش آمدید';
        $notification->text = "کاربر عزیز \n ورورد شما را به سایت آموزشی تکوان تبریک میگوییم";
        $notification->user_id = $user->id;
        $notification->save();

        //------ ارسال پیامک ثبت نام کاربر جدید

        $patterncode = "4ex85b2su5";
        $data = array("name" => $user->fname);
        $this->sendSMS($patterncode, $user->mobile, $data);

        return response()->json(
            [
                'errors' => [],
                'redirect' => route('member.dashboard', ['user' => $user->username]),
                'success' => true
            ],
            201
        );
    }
}
