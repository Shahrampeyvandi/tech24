<?php

namespace App\Http\Controllers\Panel;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
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
       
        if(isset(request()->action) && request()->action == 'read_notification' && is_numeric(request()->q)) {
           $notif =  Notification::find(request()->q);
            if($notif) {
                $notif->readed = true;
                $notif->save();
            }
        }

        $data['user'] = User::where('username',$slug)->firstOrFail();

        if(! getCurrentUser()->hasRole('admin') || $data['user']->id !== getCurrentUser()->id) abort(403);
 
        if($data['user']->hasRole('teacher')) {
            $for = 'teachers';
        }else{
            $for = 'students';
        }

        $data['notifications'] = Notification::whereIn('for',[$for,'all'])->where('readed',0)->latest()->get();
        

        return view('panel.dashboard',$data);
        
    }

    /**
     * Show posts from user.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts($slug = null)
    {
        
        $data['user'] = User::where('username',$slug)->first();

        if(! getCurrentUser()->hasRole('admin') || $data['user']->id !== getCurrentUser()->id) abort(403);
       
        if(!isset(request()->post_type) || request()->post_type == '') {
            request()->post_type = 'course';
        } 
        
        $data['title'] =  request()->post_type == 'course' ? 'دوره ها' : 'وبینارها';
        $data['posts'] = getCurrentUser()->posts()->where('post_type',request()->post_type)->latest()->get();
        
        return view('panel.posts',$data);
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

    public function show_post_lessons($user,$id)
    {   
        $data['post'] = Post::findOrFail($id);

        $data['user'] = User::where('username',$user)->firstOrFail();

        if(! getCurrentUser()->hasRole('admin') || $data['user']->id !== getCurrentUser()->id) abort(403);
        // if(! $data['user']->posts->contains($id)) abort(403);
        $data['title'] =  $data['post']->title;
        $data['lessons'] = $data['post']->lessons()->orderBy('number','asc')->get();
        
        return view('panel.show-course',$data);
      
    }
}
