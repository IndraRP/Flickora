<?php

namespace App\Livewire\User\Page;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Notif extends Component
{
    use LivewireAlert;

    public $pendingFriendships;
    public $friendshipsCount;
    public $Friendships_Count;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->pendingFriendships = Friendship::where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        $this->Friendships_Count = $this->pendingFriendships->count();

        if ($this->pendingFriendships->isEmpty()) {
            return; // Hindari error jika kosong
        }

        foreach ($this->pendingFriendships as $friendship) {
            $friendship->sender = User::find($friendship->user_id);
        }

        // Jika ada permintaan pertemanan, baru hitung friendshipsCount
        $this->friendshipsCount = Friendship::where('user_id', optional($friendship->sender)->id)
            ->where('status', 'approved')
            ->count();
    }



    public function acceptFriendship($senderId)
    {
        // Cari friendship yang statusnya 'pending' dari pengirim
        $friendship = Friendship::where('user_id', $senderId)
            ->where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            // Ubah status friendship yang diterima menjadi 'approved'
            $friendship->status = 'approved';
            $friendship->save();

            // Cari friendship di sisi sebaliknya (dari penerima ke pengirim)
            $reverseFriendship = Friendship::where('user_id', Auth::id())
                ->where('friend_id', $senderId)
                ->where('status', 'pending')
                ->first();

            if ($reverseFriendship) {
                // Ubah status menjadi 'approved' juga untuk sisi sebaliknya
                $reverseFriendship->status = 'approved';
                $reverseFriendship->save();
            }

            // Beri alert bahwa permintaan diterima
            $this->alert('success', 'Anda telah menerima permintaan pertemanan');
        }

        return redirect()->to(request()->header('Referer'));
    }


    public function rejectFriendship($senderId)
    {
        // Cari friendship yang statusnya 'pending'
        $friendship = Friendship::where('user_id', $senderId)
            ->where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            // Ubah status menjadi 'approved'
            $friendship->status = 'rejected';
            $friendship->save();

            // Beri alert bahwa permintaan diterima
            $this->alert('success', 'Anda telah menolak permintaan pertemanan');
        }

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.user.page.notif')
            ->extends('layouts.app')
            ->section('content');
    }
}
