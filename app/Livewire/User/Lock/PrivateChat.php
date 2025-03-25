<?php

namespace App\Livewire\User\Lock;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class PrivateChat extends Component
{
    public $conversations;
    public $selectedConversation;

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = Auth::user()->conversations()
            ->with(['lastMessage', 'users' => function ($query) {
                $query->where('users.id', '!=', Auth::id());
            }])
            ->latest('updated_at')
            ->get();
    }

    public function selectConversation($conversationId)
    {
        logger("Percakapan dipilih: " . $conversationId); // Debug log
        $this->selectedConversation = $conversationId;
        $this->dispatch('conversationSelected', conversationId: $conversationId);
    }

    #[On('refreshConversations')]
    public function refreshConversations()
    {
        logger('Event refreshConversations diterima!'); // Ganti dd() dengan logger() untuk debugging
        $this->loadConversations();
    }

    public function render()
    {
        return view('livewire.user.lock.private-chat')
            ->extends('layouts.app')
            ->section('content');
    }
}
