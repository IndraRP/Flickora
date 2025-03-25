<?php

namespace App\Livewire\User\Page;

use App\Models\Highlight;
use App\Models\Likes_Highlight;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Highlightdetail extends Component
{

    public $selectedIndex = 0;
    public $highlightId;
    public $liked = false;
    public $highlights = [];
    public $user;
    // public $highlightId;

    public function mount($highlightId = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->user = Auth::user();
        $this->_getHighLight();
        $this->highlightId = $highlightId;
        $this->checkLikeStatus();

        // Ambil jumlah like untuk setiap highlight
        $this->highlights = $this->highlights->map(function ($highlight) {
            $highlight->likes_count = $this->getLikeCount($highlight->id);
            return $highlight;
        });

        // Perbaiki logika pencarian index
        if ($highlightId) {
            $index = $this->highlights->search(fn($highlight) => $highlight->id == $highlightId);
            $this->selectedIndex = $index !== false ? $index : 0;

            // Kirim event ke frontend agar swiper juga pindah ke slide ini
            $this->dispatch('update-swiper', selectedIndex: $this->selectedIndex);
        }

        session()->forget('selectedIndex'); // Hapus setelah dipakai
    }

    private function getLikeCount($highlightId)
    {
        return DB::table('likes_highlight')->where('highlight_id', $highlightId)->count();
    }

    public function next()
    {
        if ($this->selectedIndex < count($this->highlights) - 1) {
            $this->selectedIndex++;
            $this->dispatch('update-swiper', selectedIndex: $this->selectedIndex);
        }
    }

    public function prev()
    {
        if ($this->selectedIndex > 0) {
            $this->selectedIndex--;
            $this->dispatch('update-swiper', selectedIndex: $this->selectedIndex);
        }
    }
    public function isLiked($highlightId)
    {
        return isset($this->likedHighlights[$highlightId]) && $this->likedHighlights[$highlightId];
    }

    public function checkLikeStatus()
    {
        if (Auth::check()) {
            $this->liked = Likes_Highlight::where('user_id', Auth::id())
                ->where('highlight_id', $this->highlightId)
                ->exists();
        }
    }

    public function toggleLike($highlightId)
    {
        if (!auth()->check()) {
            return;
        }

        if (!$highlightId) {
            throw new \Exception("Highlight ID tidak boleh null");
        }

        $existingLike = Likes_Highlight::where('user_id', auth()->id())
            ->where('highlight_id', $highlightId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Likes_Highlight::create([
                'user_id' => auth()->id(),
                'highlight_id' => $highlightId
            ]);
        }

        $this->_getHighLight();
    }

    private function _getHighLight()
    {
        $this->highlights = Highlight::with(['likes_highlight', 'liked' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->where('userId', Auth::id())->take(20)->latest()->get()->collect(); // Ubah ke koleksi
    }


    public function render()
    {
        return view('livewire.user.page.highlightdetail', [
            'highlight' => ['id' => $this->highlightId],
            'liked' => $this->liked
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
