<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $conversations = Conversation::where('private', true)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['lastMessage', 'users'])
            ->latest('updated_at')
            ->get();

        return view('chatify.private', compact('conversations'));
    }
}
