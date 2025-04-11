<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'address',
        'remember_token',
        'no_hp',
        'job',
        'avatar',
        'description',
        'post',
        'dark_mode',
        'messenger_color',
        'gender',
        'tanggal_lahir',
        'background',
        'active_status',
        'page_image',
        'pin',
        'username_changes',
        'private'
    ];


    // public function create(User $user)
    // {
    //     return true;
    // }

    public function getAvatarUrlAttribute(): ?string
    {
        // Pastikan avatar ada, kalau tidak, pakai gambar default
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('storage/avatar.png');
    }



    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function coments()
    {
        return $this->hasMany(Coments::class);
    }

    public function coments_video()
    {
        return $this->hasMany(Comment_Videos::class);
    }

    public function taggedUsers()
    {
        return $this->hasMany(Tag::class);
    }

    public function likes_highlight()
    {
        return $this->hasMany(Likes_Highlight::class);
    }

    public function likes_video()
    {
        return $this->hasMany(Likes_Video::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function reports_video()
    {
        return $this->hasMany(Report_Video::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class, // Ini akan otomatis casting role jadi enum
        ];
    }
}
