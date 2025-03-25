<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Likes_Video extends Model
{
    use HasFactory;
    protected $table = 'likes_video';
    protected $fillable = ['user_id', 'video_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function highlight()
    {
        return $this->belongsTo(Video::class);
    }
}
