<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdobeGroup extends Model
{
    protected $guarded = ['id'];


    public function users()
    {
        return $this->belongsToMany(User::class,'user_group','group_id','user_id');
    }

}
