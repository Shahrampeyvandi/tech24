<?php

namespace App\Http\Controllers\Panel;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        // dd($slug);





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

        $all_notif =  Notification::whereIn('for', [$for, 'all'])->orWhere('user_id',getCurrentUser()->id)->latest()->get();
        $unreaded  =Notification::whereIn('for', [$for, 'all'])->orWhere('user_id',getCurrentUser()->id)->whereNotIn('id',$data['user']->readedNotifications()->pluck('id')->toArray())->latest()->get();
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
        $data['posts'] = getCurrentUser()->posts()->where('post_type', request()->post_type)->latest()->get();

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
        // dd($username);
        $user= User::where('username', $username)->firstOrFail();
        $user->fname = request()->firstname;
        $user->lname = request()->lastname;
        // $user->lname = request()->email;
        if(request()->avatar) 
        {
            $name = $this->upload_avatar($username,request()->avatar);
            $user->avatar = $name;
        }

        $user->save();
        
        return Redirect::route('member.profile',$username);
    }

    public function upload_avatar($username,$file)
    {
        $date = date('Y');
       

        $imageName = $username . '.' . $file->extension();

        $file->move(public_path('uploads/' . $date . '/photos'), $imageName);
        return 'uploads/' . $date . '/photos/' . $imageName;
    }
}
