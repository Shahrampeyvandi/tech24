<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value){

        $this->attributes['password'] = Hash::make($value);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_user','user_id','post_id');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class,'group_user','user_id','group_id')->withPivot('leader');
    }

     public function readedNotifications()
    {
        return $this->belongsToMany(Notification::class,'readed_notification','user_id','notification_id');
    }
    


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    
    public function adobe_info()
    {
        return $this->hasOne(AdobeUsers::class);
    }

    public function passed_quizz()
    {
        return $this->hasMany(Passed::class);
    }

    public function unreadedNotifications()
    {
        # code...
    }
    
  
    public function getFullName()
    {
        return $this->fname . ' ' . $this->lname;
    }
     public function getPicture()
    {
        if($this->avatar) return asset($this->avatar);
        return asset('images/avatar.jpg');
    }
    
    /**
     * check if user allow see lesson
     *
     * @param  mixed $lessonId
     * @return void
     */
    public function checkAllowForSeeLesson($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if(getCurrentUser()->hasRole('admin')) return true;
        if(! getCurrentUser()->posts->contains($lesson->post->id)) return false;
        if($lesson->number == 1 ) return route('play',$lesson->post->slug).'?lesson='.$lesson->id;
        if($lesson && $lesson->number != 1) {
            $prev = Lesson::whereNumber((int)$lesson->number-1)->first();
            if($prev && $prev->quiz && Passed::where(['quiz_id'=>$prev->quiz->id,'user_id'=>$this->id])) {
                return true;
            }
            if($prev && !$prev->quiz) return true;
            return false;
        }
        return false;
        
    }

}
