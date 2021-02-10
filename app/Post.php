<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Post extends Model
{
     use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];

    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(User::class,'post_teacher','post_id','teacher_id');
    }
      public function tags()
    {
        return $this->belongsToMany(Tag::class,'post_tag','post_id','tag_id');
    }
       public function prerequisites()
    {
        return $this->belongsToMany(static::class,'post_prerequest','post_id','prerequest_id');
    }
}
