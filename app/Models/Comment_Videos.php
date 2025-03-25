<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment_Videos extends Model
{
    protected $table = 'coment_videos';
    protected $fillable = [
        'user_id',
        'video_id',
        'content',
        'parent_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Video::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment_Videos::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment_Videos::class, 'parent_id');
    }
}
