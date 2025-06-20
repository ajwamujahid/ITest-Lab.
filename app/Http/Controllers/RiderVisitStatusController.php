<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderVisitStatusController extends Controller
{
   

    public function index()
    {
        $riderId = Auth::guard('rider')->id();
    
        $appointments = Appointment::where('rider_id', $riderId)
            ->with('patient') // ✅ load related patient
            ->latest()
            ->get();
            //dd(\App\Models\Appointment::with('patient')->first()->patient);

        return view('rider.visit_status.index', compact('appointments'));
    }
    
    // Update the visit status
    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_status' => 'required|in:pending,visited,sample_collected'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->visit_status = $request->visit_status;
        $appointment->save();

        return redirect()->back()->with('success', 'Visit status updated!');
    }
}
