<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class ManagerChatController extends Controller
{
    // Manager ke saath chat karne wale patients ki list dikhayega
    public function index()
    {
        $managerId = auth('manager')->id();

        // Messages me manager ke sender ya receiver hone par uska dusra side ka ID le lo
        $patientIds = Message::where('sender_id', $managerId)
            ->pluck('receiver_id')
            ->merge(
                Message::where('receiver_id', $managerId)
                    ->pluck('sender_id')
            )
            ->unique()
            ->values();

        // Patient models get karo
        $patients = Patient::whereIn('id', $patientIds)->get();

        return view('manager.chat.index', compact('patients'));
    }

    // Manager aur ek patient ke darmiyan chat messages fetch karo
    public function chatWithPatient($patientId)
    {
        $managerId = auth('manager')->id();

        // Unread messages ko read mark kar do
        DB::table('messages')
            ->where('sender_id', $patientId)
            ->where('receiver_id', $managerId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Dono taraf ke messages order by time ke sath le lo
        $messages = DB::table('messages')
            ->where(function ($query) use ($managerId, $patientId) {
                $query->where('sender_id', $managerId)
                      ->where('receiver_id', $patientId);
            })
            ->orWhere(function ($query) use ($managerId, $patientId) {
                $query->where('sender_id', $patientId)
                      ->where('receiver_id', $managerId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $patient = Patient::findOrFail($patientId);

        return view('manager.chat.chatWithPatient', compact('messages', 'patient'));
    }

    // Manager se patient ko message bhejna
    public function sendMessage(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'message' => 'required|string',
        ]);

        $managerId = auth('manager')->id();

        DB::table('messages')->insert([
            'sender_id' => $managerId,
            'receiver_id' => $request->patient_id,
            'message' => $request->message,
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
            'attachment' => null,
        ]);

        return redirect()->back();
    }
}
