<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentCancelController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->whereIn('status', ['scheduled', 'pending']) // show only active ones
            ->latest()
            ->get();

        return view('appointments.cancel', compact('appointments'));
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}
