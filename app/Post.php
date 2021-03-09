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

     public function getPicture()
     {
         return $this->picture ? asset($this->picture) : asset('assets/imgs/Logo.png');
     }

     public function getImplodeCategories()
     {

        $category_id = $this->category_id;
         
         
        
         do {

            $cat = Category::find($category_id);
            $arr[] = $cat->title;
            $category_id = $cat->parent_id;
            // dd($category_id);
             
         } while ($category_id !== 0);
         
        
        //  dd($arr);
        
         return implode('> ',array_reverse($arr)); 

     }
     public function getTeacher()
     {
         $teacher = $this->teachers->first();
         if(! $teacher) return '#';
         return $teacher->fname . ' ' . $teacher->lname; 
     }

     public function getPrice()
     {
         if($this->cash == 'money') {
            return number_format((int)$this->price) . ' تومان';
         }
         return 'رایگان';
     }

     public function url()
     {
         return route('post.show',$this->slug);
     }


    public function teacher_name()
    {
        $teachers = $this->teachers;
       
        $name = '';
        if(count($teachers)) {
            foreach ($teachers as $key => $teacher) {
                $name .= $teacher->fname . ' ' . $teacher->lname . ' ' ;
           
                
            }
    
        }
       
        return $name;
    }
}
