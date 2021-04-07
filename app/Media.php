<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Media extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }
}
