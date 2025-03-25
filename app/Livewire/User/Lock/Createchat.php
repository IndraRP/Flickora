<?php

namespace App\Livewire\User\Lock;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Createchat extends Component
{
    public $searchQuery = '';
    public $searchResults = [];
    public $selectedUser = null;

    public function updatedSearchQuery()
    {
        if (strlen($this->searchQuery) >= 2) {
            $this->searchResults = User::where('id', '!=', Auth::id())
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->searchQuery . '%')
                        ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
                })
                ->limit(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectUser(User $user)
    {
        $this->selectedUser = $user;
        $this->searchQuery = '';
        $this->searchResults = [];
    }

    public function startConversation()
    {
        if (!$this->selectedUser) {
            return;
        }

        // Check if conversation already exists
        $existingConversation = Conversation::whereHas('users', function ($query) {
            $query->where('users.id', Auth::id());
        })->whereHas('users', function ($query) {
            $query->where('users.id', $this->selectedUser->id);
        })->where('is_group', false)
            ->first();

        if ($existingConversation) {
            $this->dispatch('conversationSelected', conversationId: $existingConversation->id);
            $this->reset('selectedUser');
            return;
        }

        // Create new conversation
        $conversation = Conversation::create(['is_group' => false]);
        $conversation->users()->attach([Auth::id(), $this->selectedUser->id]);

        $this->dispatch('conversationSelected', conversationId: $conversation->id);
        $this->dispatch('refreshConversations');
        $this->reset('selectedUser');
    }

    public function render()
    {
        return view('livewire.user.lock.createchat')
            ->extends('layouts.app')
            ->section('content');
    }
}
