<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // ✅ Add this line
use App\Events\NewMessage; // ✅ If you're using real-time Pusher events

class MessageController extends Controller
{
    public function index()
{
    $userId = auth()->id();
    $messages = Message::where('sender_id', $userId)
        ->orWhere('receiver_id', $userId)
        ->orderBy('created_at')
        ->get();

    return view('chat.index', compact('messages'));
}

public function store(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string',
    ]);

    Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
    ]);

    return back()->with('success', 'Message sent.');
}

}
