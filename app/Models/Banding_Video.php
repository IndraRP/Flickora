<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banding_Video extends Model
{
    protected $table = 'bandings_video';
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Post
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Relasi ke Report (jika ada tabel reports)
     */
    public function report_video()
    {
        return $this->belongsTo(Report_Video::class);
    }
}
