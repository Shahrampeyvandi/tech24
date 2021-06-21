<?php

namespace App;

use App\Http\Traits\FullTextSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use  Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
     use Sluggable,FullTextSearch;
    
  

       public const PODCASTS_COUNT=6;
       public const COURSES_COUNT=4;
       public const WEBINARS_COUNT=4;
   

       /**
      * The columns of the full text index
      */
      protected $searchable = [
        'title',
        'description'
    ];

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
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
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

    public function adobeGroup()
    {
        return $this->hasOne(AdobeGroup::class);
    }

    

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


     
        
    /**
     *  Relation with Files
     *
     * @return MorphMany
     */
    public function files() : MorphMany
    {
        return $this->morphMany(File::class, 'filable');
    }

    /**
     * Get post file url
     */

     public function getFileUrl():string
     {
         $file = $this->files->first();
         if($file) {

             return asset($file->file);
         }
         return '#';
     }

     public function getPicture():string
     {
         return $this->picture ? asset($this->picture) : asset('assets/imgs/Logo.png');
     }

     public function getImplodeCategories():string
     {
        $category_id = $this->category_id;
        
         do {

            $cat = Category::find($category_id);
            $arr[] = $cat->title;
            $category_id = $cat->parent_id;
            // dd($category_id);

         } while ($category_id !== 0);

        //  dd($arr);
         $string = '';
        foreach ($arr as $item) {
            $string .= $item . ' <i class="icon-caret-left mx-2"></i> ';
        }

         return  $string;

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
             if(Auth::check() && getCurrentUser()->posts->contains($this->id))
               return 'شما این '.$this->getPostType('fa').' را خریده اید';
            return number_format((int)$this->price) . ' تومان';
         }
         return 'رایگان';
     }

     public function getPostType($ln = 'en')
     {
         $type = $this->post_type;
         if($type == 'course') {
             return $ln == 'en' ? 'course' : 'دوره';
         }
         if($type == 'webinar') {
            return $ln == 'en' ? 'webinar' : 'وبینار';
        }
        if($type == 'podcast') {
            return $ln == 'en' ? 'podcast' : 'پادکست';
        }
     }

     public function url()
     {

        if(getCurrentUser()) {
            if(getCurrentUser()->posts->contains($this->id)) {
                return '<a href="'.route('play',$this->slug) .'" class="py-2 px-5 btn_orange mr-4 mt-2">مشاهده</a>';

            }
            if($this->cash == 'money')  return route('post.',$this->slug);
            return '<a href="'.route('post.register',$this->slug) .'" class="py-2 px-5 btn_orange mr-4 mt-2">ثبت نام</a>';

        }
        return '<a href="'.route('post.register',$this->slug) .'" class="py-2 px-5 btn_orange mr-4 mt-2">ثبت نام</a>';
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
