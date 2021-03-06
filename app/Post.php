<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['image', 'user_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes_count()
    {
        return $this->hasMany(Like::class)->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->get();
    }
}
