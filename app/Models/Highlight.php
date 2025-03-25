<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Highlight extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'image', 'title'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function likes_highlight()
    {
        return $this->hasMany(Likes_Highlight::class);
    }

    /**
     * Get the liked associated with the Highlight
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function liked(): HasOne
    {
        return $this->hasOne(Likes_Highlight::class, 'highlight_id', 'id');
    }
}
