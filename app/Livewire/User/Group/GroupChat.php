<?php

namespace App\Livewire\User\Group;

use App\Models\ChMessage;
use App\Models\Group; // Pastikan Group di-import
use Livewire\Component;

class GroupChat extends Component
{
    public $group;
    public $message;
    public $messages;

    public $listeners = ['newMessage' => 'handleNewMessage'];

    protected $rules = [
        'message' => 'required|string|max:255',
    ];

    // Menampilkan pesan saat pertama kali dimuat
    public function mount(Group $group)
    {
        $this->group = $group;
        // Pastikan ini adalah koleksi Eloquent
        $this->messages = $group->messages()->with('user')->get(); // Ambil pesan awal sebagai koleksi
    }

    // Kirim pesan
    public function sendMessage()
    {
        $this->validate();

        // Simpan pesan ke database
        $message = new ChMessage([
            'user_id' => auth()->id(),
            'group_id' => $this->group->id,
            'message' => $this->message,
        ]);
        $message->save();

        // Reset input pesan
        $this->message = '';

        // Broadcast pesan
        broadcast(new \App\Events\MessageSent($message)); // Menggunakan event broadcasting

        // Update pesan yang ditampilkan
        $this->messages = $this->group->messages()->with('user')->get(); // Dapatkan koleksi terbaru
    }

    // Tangani pesan baru dari event
    public function handleNewMessage($message)
    {
        // Jika $messages adalah koleksi, push() akan bekerja dengan baik
        $this->messages->push($message); // Menambahkan pesan baru ke koleksi
    }

    // Render tampilan
    public function render()
    {
        return view('livewire.user.group.group-chat')
            ->extends('layouts.app')
            ->section('content');
    }
}
