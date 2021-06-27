<?php

namespace App\Http\Controllers\Panel;

use App\Post;
use App\User;
use App\Group;
use Carbon\Carbon;
use App\TokenReset;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Toastr;


class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
    


        $data['user'] = User::where('username', $slug)->firstOrFail();
     
        // if(getCurrentUser()->hasRole('admin')){

        // }
        if (!getCurrentUser()->hasRole('admin') && $data['user']->id !== getCurrentUser()->id) abort(403);

        if ($data['user']->hasRole('teacher')) {
            $for = 'teachers';
        } else {
            $for = 'students';
        }

        if (request()->action) {
            if (request()->action == 'read_notification' && is_numeric(request()->id)) {


                $notif =  Notification::find(request()->id);
                if ($notif) {
                    // dd('d');
                   $data['user']->readedNotifications()->attach($notif->id);
                }
            }
        }
        $all_notif =  Notification::whereIn('for', [$for, 'all'])->orWhere('user_id',$data['user']->id)->latest()->get();
        $unreaded  = Notification::whereIn('for', [$for, 'all'])->orWhere('user_id',$data['user']->id)->latest()->get();
        $unreaded = collect($unreaded)->whereNotIn('id',$data['user']->readedNotifications()->pluck('id')->toArray());
        
        $readed = $data['user']->readedNotifications;
        
        if (request()->q) {
            if (request()->q == 'unread_notifications') {

                $data['notifications'] =  $unreaded;
            }
            elseif (request()->q == 'readed_notifications') {
                $data['notifications'] =   $readed;
                // $data['notifications'] = Notification::whereIn('for', [$for, 'all'])->where('readed', 1)->latest()->get();
            }else{
                $data['notifications'] = $all_notif;
            }
        } else {

            $data['notifications'] = $all_notif;
        }
       

        $data['notifCounts'] = [
            'readed' => count($readed),
            'unreaded' => count($unreaded),
            'all' => count($all_notif),
        ];



        return view('panel.dashboard', $data);
    }

    /**
     * Show posts from user.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts($slug = null)
    {

        $data['user'] = User::where('username', $slug)->first();

        if (!getCurrentUser()->hasRole('admin') && $data['user']->id !== getCurrentUser()->id) abort(403);

        if (!isset(request()->post_type) || request()->post_type == '') {
            request()->post_type = 'course';
        }

        $data['title'] =  request()->post_type == 'course' ? 'دوره ها' : 'وبینارها';
        $data['posts'] = $data['user']->posts()->where('post_type', request()->post_type)->latest()->get();

        return view('panel.posts', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function show_post_lessons($user, $id)
    {
        $data['post'] = Post::findOrFail($id);

        $data['user'] = User::where('username', $user)->firstOrFail();

        if (!getCurrentUser()->hasRole('admin') && $data['user']->id !== getCurrentUser()->id) abort(403);
        // if(! $data['user']->posts->contains($id)) abort(403);
        $data['title'] =  $data['post']->title;
        $data['lessons'] = $data['post']->lessons()->orderBy('number', 'asc')->get();

        return view('panel.show-course', $data);
    }

    
    public function profile($username)
    {
        $data['user'] = User::where('username', $username)->firstOrFail();
        return view('panel.profile',$data);
    }
    public function updateProfile($username)
    {

        if(Auth::user()->id != request('user_id')) {
            if (!Auth::user()->hasRole('admin')) abort(403);
        }
        $user= User::where('id', request('user_id'))->firstOrFail();
       
        $validator = Validator::make(request()->all(), [
            'firstname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u'],
            'lastname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+[a-zA-Z\d]*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', Rule::unique('users')->ignore($user->id), 'string', 'regex:/^[a-zA-Z]+[a-zA-Z\d_~\-!@#\$%\^&*\(\)]*$/u','min:5', 'max:15'],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/', Rule::unique('users','mobile')->ignore($user->id)],
        ],[

            'fname.regex' => 'نام شما باید تنها شامل حروف لاتین باشد',
            'lname.regex' => 'نام خانوادگی شما باید تنها شامل حروف لاتین باشد',
            'code' => 'کد ارسالی شما مطابقت ندارد لطفا لحظاتی دیگر مجددا تلاش کنید',
            'password.regex' => 'رمز عبور باستی حداقل 8 کاراکتر و شامل حداقل یک حرف کوچک یک حرف بزرگ و یک عدد و یک کاراکتر خاص باشد',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    

        $user->fname = request()->firstname;
        $user->lname = request()->lastname;
        $user->email = request()->email;
        $user->mobile = request()->phone;
       
        $user->username = request()->username;

        if(request()->avatar) 
        {
            $name = $this->upload_avatar($username,request()->avatar);
            $user->avatar = $name;
        }

        $user->save();
        $message = 'اطلاعات شما با موفقیت بروزرسانی شد';
        

        if(request()->code){
            $passreset = TokenReset::where('mobile', request()->phone)
            ->where('code', request()->code)->first();
                if($passreset){

                    $user->mobile_verified = 1;
                    $message = 'اطلاعات شما با موفقیت به روز رسانی و شماره موبایل شما مورد تایید قرار گرفت';
                    $notification = new Notification;
                    $notification->title = 'تایید شماره موبایل';
                    $notification->text = "کاربر عزیز \n شماره موبایل شما با شماره $user->mobile مورد تایید قرار گرفت";
                    $notification->user_id = $user->id;
                    $notification->save();
                    $user->save();

               
                }
            }

            

        Toastr::success($message);
        return Redirect::route('member.profile',$user->username);
    }

    public function chat(Group $group)
    {
        dd($group);
        return view('panel.chat');
    }
    public function upload_avatar($username,$file)
    {
        $date = date('Y');
       

        $imageName = $username . '.' . $file->extension();

        $file->move(public_path('uploads/' . $date . '/photos'), $imageName);
        return 'uploads/' . $date . '/photos/' . $imageName;
    }
    
    /**
     * verifyMobile
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function verifyMobile(Request $request) : JsonResponse
    {
        $user = Auth::user();
        $patterncode  = '6onq2eu1g2';
        // validate mobile
        $validator = Validator::make($request->all(),[
            'mobile' => ['required', Rule::unique('users')->ignore($user->id, 'id'),'regex:/(09)[0-9]{9}/']
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => false, 'errors' => ['message' => $validator->errors()]], 422);

        }


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

       
        return Response::json([
            'success' => true,
            'timer' => date('Y/m/d H:i:s', strtotime('00:02:00'))
        ], 200);
        
    }
}
