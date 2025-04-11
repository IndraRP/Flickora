<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function post()
    // {
    //     return $this->belongsTo(Post::class);
    // }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
