<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Lesson extends Model
{

    protected $guarded = ['id'];
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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function quiz()
    {
        return $this->morphOne(Quiz::class, 'quizable');
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

            return $file->file;
        }
        return '#';
    }

    public function getPicture()
    {
        return $this->picture ? asset($this->picture) : asset('assets/imgs/Logo.png');
    }
}
