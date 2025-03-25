<?php

namespace App\Livewire\User\Group;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Group extends Component
{
    public $posts;
    public $user;
    public $users;

    public function mount()
    {
        $this->user = Auth::user();
        $this->users = User::get();
        $this->posts = Post::where('user_id', $this->user->id)->get();
    }

    public function render()
    {
        return view('livewire.user.group.group')
            ->extends('layouts.app')
            ->section('content');
    }
}
