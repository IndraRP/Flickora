<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'video',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coment_videos()
    {
        return $this->hasMany(Comment_Videos::class);
    }

    public function likes_video()
    {
        return $this->hasMany(Likes_Video::class);
    }

    public function report_video()
    {
        return $this->hasOne(Report_Video::class);
    }
}
