<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_Video extends Model
{
    use HasFactory;
    protected $table = 'reports_video';
    protected $fillable = ['video_id', 'user_id', 'alasan'];

    // Relasi ke Post
    public function video()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi ke User (Pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // public function reports()
    // {
    //     return $this->hasMany(Banding::class);
    // }
}
