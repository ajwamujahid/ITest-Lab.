<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ManagementChatController extends Controller
{
    public function index(Request $request)
    {
        $managementId = auth()->id(); // Or manually set if not using auth

        // Find all conversations where this management user is a participant
        $conversations = Conversation::whereHas('participants', function ($q) use ($managementId) {
            $q->where('participant_id', $managementId)
              ->where('participant_type', 'management');
        })->with(['messages' => function($q) {
            $q->orderBy('created_at');
        }])->get();

        return view('chat.management', compact('conversations', 'managementId'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $request->validate(['message' => 'required|string']);

        $managementId = auth()->id(); // Or manually use a fixed ID for now

        $isParticipant = $conversation->participants()
            ->where('participant_id', $managementId)
            ->where('participant_type', 'management')
            ->exists();

        if (!$isParticipant) {
            abort(403, 'You are not part of this conversation.');
        }

        $conversation->messages()->create([
            'sender_id' => $managementId,
            'sender_type' => 'management',
            'message' => $request->message,
        ]);

        return back();
    }
}
