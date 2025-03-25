<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Likes_Highlight extends Model
{
    use HasFactory;
    protected $table = 'likes_highlight';
    protected $fillable = ['user_id', 'highlight_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function highlight()
    {
        return $this->belongsTo(Highlight::class);
    }
}
