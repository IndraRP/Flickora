<?php

namespace App\Http\Controllers;

use App\Models\ChMessage;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{
    public function createGroup(Request $request)
    {
        $group = Group::create(['name' => $request->name]);
        $group->members()->attach($request->user_ids); // Menambahkan anggota ke grup
        return redirect()->route('group.chat', $group->id);
    }

    public function sendMessage(Request $request, $groupId)
    {
        $group = Group::find($groupId);
        $message = new ChMessage([
            'user_id' => auth()->id(),
            'group_id' => $group->id,
            'message' => $request->message
        ]);
        $message->save();

        broadcast(new \App\Events\MessageSent($message)); // Event untuk broadcasting

        return response()->json($message);
    }
}
