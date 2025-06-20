<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;

class ChatController extends Controller
{
    
public function managerIndex()
{
    $manager = Auth::guard('manager')->user();

    // 🛠 Manually get department where manager_id = current manager
    $department = Department::where('manager_id', $manager->id)->first();
    $departmentName = strtolower($department->name ?? '');

    if ($departmentName !== 'chat') {
        abort(403, 'Unauthorized');
    }

        // ✅ Get all patient IDs who messaged this manager
        $patientIds = Message::where('receiver_type', 'manager')
                        ->where('receiver_id', $manager->id)
                        ->where('sender_type', 'patient')
                        ->pluck('sender_id')
                        ->unique();
    
        $patients = collect();
    
        foreach ($patientIds as $pid) {
            $patient = Patient::find($pid);
            if ($patient) {
                // 🔴 Count unread messages from this patient
                $unreadCount = Message::where('sender_id', $pid)
                    ->where('sender_type', 'patient')
                    ->where('receiver_id', $manager->id)
                    ->where('receiver_type', 'manager')
                    ->where('is_read', false)
                    ->count();
    
                $patients->push((object)[
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'unread' => $unreadCount,
                ]);
            }
        }
    
        return view('chat.manager', compact('patients'));
    }
    

    public function patientIndex()
{
    $patientId = Auth::guard('patient')->id();

    // ✅ Mark manager messages as read when patient opens the chat
    Message::where('sender_type', 'manager')
        ->where('receiver_id', $patientId)
        ->where('receiver_type', 'patient')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    // 📨 Load messages
    $messages = Message::where(function ($q) use ($patientId) {
        $q->where('sender_id', $patientId)
          ->where('sender_type', 'patient');
    })->orWhere(function ($q) use ($patientId) {
        $q->where('receiver_id', $patientId)
          ->where('receiver_type', 'patient');
    })->orderBy('created_at')->get();

    $chatDeptManagerId = Department::where('name', 'chat')->value('manager_id');

    return view('chat.patient', compact('messages', 'chatDeptManagerId'));
}


// 🔹 Manager: Open chat with specific patient
public function showPatientMessages($patientId)
{
    $managerId = Auth::guard('manager')->id();

    // ✅ Mark patient's unread messages as read
    Message::where('sender_id', $patientId)
        ->where('sender_type', 'patient')
        ->where('receiver_id', $managerId)
        ->where('receiver_type', 'manager')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    // 💬 Fetch full chat (both directions)
    $messages = Message::where(function ($q) use ($patientId, $managerId) {
        $q->where('sender_id', $patientId)
          ->where('sender_type', 'patient')
          ->where('receiver_id', $managerId)
          ->where('receiver_type', 'manager');
    })->orWhere(function ($q) use ($patientId, $managerId) {
        $q->where('sender_id', $managerId)
          ->where('sender_type', 'manager')
          ->where('receiver_id', $patientId)
          ->where('receiver_type', 'patient');
    })->orderBy('created_at')->get();

    return view('chat.manager-chat', compact('messages', 'patientId'));
}


    // 🔹 Send message from PATIENT
    public function sendFromPatient(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|string',
            'message' => 'nullable|string',
            'attachment' => 'nullable|file',
        ]);

        $message = new Message();
        $message->sender_id = auth('patient')->id();
        $message->sender_type = 'patient';
        $message->receiver_id = $data['receiver_id'];
        $message->receiver_type = $data['receiver_type'];
        $message->message = $data['message'];

        if ($request->hasFile('attachment')) {
            $message->attachment = $request->file('attachment')->store('attachments', 'public');
        }

        $message->save();

        return back()->with('success', 'Message sent!');
    }

    public function sendFromManager(Request $request)
{
    $data = $request->validate([
        'receiver_id' => 'required|integer',
        'receiver_type' => 'required|string',
        'message' => 'nullable|string',
        'attachment' => 'nullable|file',
    ]);

    $message = new Message();
    $message->sender_id = auth('manager')->id();
    $message->sender_type = 'manager';
    $message->receiver_id = $data['receiver_id'];
    $message->receiver_type = $data['receiver_type'];
    $message->message = $data['message'];
    $message->is_read = false; // 👈 Important!

    if ($request->hasFile('attachment')) {
        $message->attachment = $request->file('attachment')->store('attachments', 'public');
    }

    $message->save();

    return back()->with('success', 'Message sent!');
}

}
