<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentRescheduleController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->where('status', 'cancelled')
            ->latest()
            ->get();
    
        return view('appointments.reschedule', compact('appointments'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date|after:today',
        ]);
    
        $appointment = Appointment::findOrFail($id);
        $appointment->appointment_date = $request->appointment_date;
        $appointment->status = 'scheduled'; // 👈 update status after reschedule
        $appointment->save();
    
        return back()->with('success', 'Appointment rescheduled successfully.');
    }
    
}
