<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Comment extends Model
{
    protected $fillable = [
        'comment', 'approved', 'parent_id', 'commentable_id', 'commentable_type','user_id'
    ];
    

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'parent_id','id');
    }

    public function getAutor(): string
    {
        return $this->user ? $this->user->fname . ' ' . $this->user->lname : '#';
    }
    public function getDate(): string
    {
        return Jalalian::forge($this->created_at)->ago();
    }
}
