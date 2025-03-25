<?php

namespace App\Livewire\User\Lock;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Addconver extends Component
{
    public $searchQuery = '';
    public $searchResults = [];
    public $selectedUsers = [];
    public $groupName = '';
    public $isGroup = false;

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
        // Check if user is already selected
        if (!collect($this->selectedUsers)->contains('id', $user->id)) {
            $this->selectedUsers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ];
        }

        $this->searchQuery = '';
        $this->searchResults = [];

        // If more than one user is selected, enable group chat option
        if (count($this->selectedUsers) > 1) {
            $this->isGroup = true;
        }
    }

    public function removeUser($index)
    {
        unset($this->selectedUsers[$index]);
        $this->selectedUsers = array_values($this->selectedUsers);

        // If only one user remains, disable group chat
        if (count($this->selectedUsers) <= 1) {
            $this->isGroup = false;
            $this->groupName = '';
        }
    }

    public function createConversation()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Pilih minimal satu pengguna untuk memulai percakapan.');
            return;
        }

        // For one-on-one chat, check if conversation already exists
        if (count($this->selectedUsers) === 1 && !$this->isGroup) {
            $existingConversation = Conversation::whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            })->whereHas('users', function ($query) {
                $query->where('users.id', $this->selectedUsers[0]['id']);
            })->where('is_group', false)
                ->first();

            if ($existingConversation) {
                $this->dispatch('conversationSelected', conversationId: $existingConversation->id);
                $this->reset(['searchQuery', 'searchResults', 'selectedUsers', 'groupName', 'isGroup']);
                return;
            }
        }

        // Create new conversation
        $conversation = Conversation::create([
            'name' => $this->isGroup ? $this->groupName : null,
            'is_group' => $this->isGroup
        ]);

        // Attach users
        $userIds = collect($this->selectedUsers)->pluck('id')->toArray();
        $userIds[] = Auth::id(); // Add current user
        $conversation->users()->attach($userIds);

        // Notify components to update
        $this->dispatch('refreshConversations');
        $this->dispatch('conversationSelected', conversationId: $conversation->id);

        // Reset form
        $this->reset(['searchQuery', 'searchResults', 'selectedUsers', 'groupName', 'isGroup']);
    }


    public function render()
    {
        return view('livewire.user.lock.addconver')
            ->extends('layouts.app')
            ->section('content');
    }
}
