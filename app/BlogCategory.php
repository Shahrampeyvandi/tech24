<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $guarded = ['id'];

     public static function check($name)
   {
       if($obj = static::where('name',$name)->first()){
            return $obj->id;
       }else{
           return null;
       }
   }

//    public function blogs()
//    {
//        return $this->belongsToMany(Blog::class, 'blog_bcategory', 'category_id', 'blog_id');
//    }
}
