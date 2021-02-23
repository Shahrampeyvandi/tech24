<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];
    public function filable()
    {
        return $this->morphTo();
    }
}
