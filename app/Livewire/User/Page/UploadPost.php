<?php

namespace App\Livewire\User\Page;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadPost extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $post, $content, $imagePreview, $taggedUsers = [];
    public $userId;

    public $searchQuery = '';
    public $searchResults = [];

    protected $updatesQueryString = ['searchQuery'];

    public function mount()
    {
        $this->imagePreview = session()->get('imagePreview', null);
        $this->taggedUsers = []; // Ensure it's initialized
        $this->searchResults = []; // Ensure it's initialized
    }

    public function savePost()
    {
        $this->validate([
            'content' => 'required|string|max:1000',
            'taggedUsers' => 'array',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'image' => str_replace(asset('storage/'), '', $this->imagePreview),
            'content' => $this->content,
        ]);

        // Simpan tag user yang ditandai
        if (!empty($this->taggedUsers)) {
            foreach ($this->taggedUsers as $userId) {
                Tag::create([
                    'user_id' => $userId,
                    'post_id' => $post->id,
                ]);
            }
        }

        $this->reset(['post', 'content', 'imagePreview', 'taggedUsers']);
        $this->alert('success', 'Berhasil Upload Postingan');
        return redirect()->route('page');
    }

    // Add this method to ensure properties are correctly updated
    public function updatedSearchQuery()
    {
        Log::info("Search Query Updated: " . $this->searchQuery);

        if (strlen(trim($this->searchQuery)) >= 2) {
            $this->searchResults = User::where('name', 'like', '%' . $this->searchQuery . '%')
                ->limit(5)
                ->get()
                ->toArray();

            Log::info("Search Results: " . json_encode($this->searchResults));
        } else {
            $this->searchResults = [];
        }
    }

    public function addTaggedUser($userId)
    {
        if (!in_array($userId, $this->taggedUsers)) {
            $this->taggedUsers[] = $userId;
            // Reset pencarian setelah menambahkan teman
            $this->reset('searchQuery');
            $this->searchResults = [];
        }
    }

    public function removeTaggedUser($index)
    {
        unset($this->taggedUsers[$index]);
        $this->taggedUsers = array_values($this->taggedUsers);
    }

    public function getUserName($userId)
    {
        return User::find($userId)?->name ?? 'Unknown';
    }

    public function render()
    {
        return view('livewire.user.page.upload-post')
            ->extends('layouts.app')
            ->section('content');
    }
}
