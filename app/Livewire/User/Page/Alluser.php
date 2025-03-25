<?php

namespace App\Livewire\User\Page;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Alluser extends Component
{
    public $users;
    public $banners;
    public $search = '';
    public $searchResults = [];

    public $genderFilter = 'all';
    public $genderOptions = ['all' => 'Semua', 'laki_laki' => 'Laki Laki', 'perempuan' => 'Perempuan'];

    public $friendshipsCount = [];

    public function mount()
    {
        $this->users = User::get();
        $this->banners = Banner::where('status', 'active')->get();

        $this->friendshipsCount = DB::table('friendships')
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'approved')
            ->groupBy('user_id')
            ->pluck('total', 'user_id')
            ->toArray();
    }

    public function applyGenderFilter()
    {
        $this->users = User::when($this->genderFilter !== 'all', function ($query) {
            return $query->where('gender', $this->genderFilter);
        })->get();
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
        return view('livewire.user.page.alluser')
            ->extends('layouts.app')
            ->section('content');
    }
}
