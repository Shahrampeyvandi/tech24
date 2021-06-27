<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function members()
    {
        return $this->belongsToMany(User::class,'group_user','group_id','user_id')->withPivot('leader');
    }
    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
