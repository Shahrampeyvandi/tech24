<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable , HasRoles;

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

    public function checkAllowForSeeLesson($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if($lesson->number == 1 ) return route('play',$lesson->post->slug).'?lesson='.$lesson->id;
        if($lesson && $lesson->number != 1) {
            $prev = Lesson::whereNumber((int)$lesson->number-1)->first();
            if($prev && $prev->quiz && Passed::where(['quiz_id'=>$prev->quiz->id,'user_id'=>$this->id])) {
                return route('play',$lesson->post->slug).'?lesson='.$lesson->id;
            }
            return '#';
        }
        return '#';
        
    }

}
