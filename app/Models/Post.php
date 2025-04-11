<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'post_id');
    }

    // public function tag()
    // {
    //     return $this->hasOne(Tag::class);
    // }


    // di model Post.php
    public function userTags($userId)
    {
        return $this->hasMany(Tag::class)->where('user_id', $userId);
    }


    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function coments()
    {
        return $this->hasMany(Coments::class);
    }

    public function taggedUsers()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }
}
