<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'report_id',
        'alasan',
        'bukti',
        'report_reason'
    ];

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
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Relasi ke Report (jika ada tabel reports)
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
