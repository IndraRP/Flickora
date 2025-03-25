<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_group'];

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function lastMessage()
    {
        return $this->hasOne(Messages::class)->latest();
    }
}
