<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  protected $guarded = ['id'];

  public function post()
  {
    return $this->belongsTo(Post::class);
  }
  public function getDescriptionAttribute($value)
  {
    return nl2br(e($value), false);
  }
}
