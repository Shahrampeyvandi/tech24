<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $guarded = ['id'];

    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
