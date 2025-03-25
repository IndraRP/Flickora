<?php

namespace App\Livewire\User\Page;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Friendships extends Component
{
    public $friendships;
    public $friendshipsCount;
    public $search = '';
    public $searchResults = [];

    public function mount()
    {
        $this->friendships = DB::table('friendships')
            ->join('users', 'friendships.friend_id', '=', 'users.id')
            ->where('friendships.user_id', Auth::id())
            ->where('friendships.status', 'approved')
            ->select('users.id', 'users.username', 'users.avatar')
            ->get();

        $this->friendshipsCount = DB::table('friendships')
            ->select('friend_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'approved')
            ->groupBy('friend_id')
            ->pluck('total', 'friend_id')
            ->toArray();
    }

    public function searchUsers()
    {
        // Pencarian user berdasarkan nama atau email
        if ($this->search) {
            $this->searchResults = collect(User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->get()); // Mengubah menjadi koleksi
        } else {
            $this->searchResults = collect(); // Kosongkan jika tidak ada pencarian
        }
    }

    public function render()
    {
        return view('livewire.user.page.friendships')
            ->extends('layouts.app')
            ->section('content');
    }
}
