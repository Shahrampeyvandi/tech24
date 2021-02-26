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
        return $this->belongsTo(Category::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public function quiz()
    {
        return $this->morphOne(Quiz::class, 'quizable');
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
    public function registered()
    {
        return $this->belongsToMany(User::class,'post_user','post_id','user_id');
    }

     /**
     * Get the post's files.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'filable');
    }
    /**
     * Get post file url
     */

     public function getFileUrl()
     {
         $file = $this->files->first();
         if($file) {

             return asset($file->file);
         }
         return '#';
     }

     public function getTeacher()
     {
         return $this->teachers->first()->fname . ' ' . $this->teachers->first()->lname; 
     }



    public function teacher_name()
    {
        $teachers = $this->teachers;
        $name = '';
        foreach ($teachers as $key => $teacher) {
            $name .= $teacher->fname . ' ' . $teacher->lname . ' ' ;
       
            
        }

        return $name;
    }
}
