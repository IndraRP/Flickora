<?php

namespace App\Livewire\User\Group;

use Livewire\Component;

class GrupDetail extends Component
{
    public function render()
    {
        return view('livewire.user.group.grup-detail')
            ->extends('layouts.app')
            ->section('content');
    }
}
