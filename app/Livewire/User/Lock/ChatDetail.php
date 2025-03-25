<?php

namespace App\Livewire\User\Lock;

use Livewire\Component;

class ChatDetail extends Component
{
    public function render()
    {
        return view('livewire.user.lock.chat-detail')
            ->extends('layouts.app')
            ->section('content');
    }
}
