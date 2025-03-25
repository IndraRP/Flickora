<?php

namespace App\Livewire\User\Lock;

use App\Models\Conversation;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Chatbox extends Component
{
    public $conversationId;
    public $messages = [];
    public $messageText = '';
    public $conversation;
    public $otherUser;
    public $showChatbox = false;

    public function mount()
    {
        // Kosong, akan diisi ketika percakapan dipilih
    }

    #[On('conversationSelected')]
    public function loadConversation($conversationId)
    {
        logger("Chatbox menerima event dengan ID: " . $conversationId); // Gunakan logger bukan dd()
        $this->conversationId = $conversationId;
        $this->showChatbox = true;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->conversationId) {
            return;
        }

        $this->conversation = Conversation::with(['users' => function ($query) {
            $query->where('users.id', '!=', Auth::id());
        }])->find($this->conversationId);

        if ($this->conversation) {
            $this->messages = Messages::with('user')
                ->where('conversation_id', $this->conversationId)
                ->latest()
                ->limit(50)
                ->get()
                ->reverse()
                ->values();

            $this->otherUser = $this->conversation->users->first();
        }
    }

    public function sendMessage()
    {
        if (!$this->messageText || !$this->conversationId) {
            return;
        }

        $message = Messages::create([
            'conversation_id' => $this->conversationId,
            'user_id' => Auth::id(),
            'body' => $this->messageText,
        ]);

        $this->conversation->touch(); // Update conversation timestamp
        $this->messageText = '';

        logger('Event refreshConversations dikirim!'); // Gunakan logger bukan dd()
        $this->dispatch('refreshConversations');

        $this->loadMessages();
    }

    public function notifyNewMessage($event)
    {
        logger('Pesan baru diterima melalui Pusher');
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.user.lock.chatbox');
    }
}
