<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;

class ChMessage extends Model
{
    use UUID;
    protected $fillable = ['user_id', 'group_id', 'message'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
