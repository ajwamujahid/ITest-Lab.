<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentCancelController extends Controller
{


    public function index()
    {
        $patientId = Auth::guard('patient')->id(); // 👈 this is better for patient
    
        $appointments = Appointment::with('patient')
            ->where('patient_id', $patientId)
            ->whereIn('status', ['scheduled', 'pending'])
            ->latest()
            ->get();
    
        return view('appointments.cancel', compact('appointments'));
    }
    

    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', auth()->id()) // ✅ Ensure only own appointment can be canceled
            ->firstOrFail();

        $appointment->status = 'cancelled';
        $appointment->save();

        return back()->with('success', 'Your appointment has been cancelled successfully.');
    }
}
