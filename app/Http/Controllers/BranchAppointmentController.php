<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestRequest;
use App\Models\Rider;
use App\Models\Appointment;

use Illuminate\Support\Facades\Auth;

class BranchAppointmentController extends Controller
{
    // Show all online test requests for this branch
    public function showOnlineRequests()
    {
        $branchId = Auth::guard('branchadmin')->user()->branch_id;

        $requests = TestRequest::where('test_type', 'online')
        ->where('branch', $branchId)
        ->whereNotIn('id', Appointment::pluck('test_request_id')) // only unassigned
        ->get();
        dd([
            'branch_id' => $branchId,
            'all_online' => TestRequest::where('test_type', 'online')->get(),
            'unassigned' => TestRequest::where('test_type', 'online')
                ->where('branch_id', $branchId)
                ->whereNotIn('id', Appointment::pluck('test_request_id'))
                ->get(),
            'appointments' => Appointment::pluck('test_request_id')
        ]);
        

        $riders = Rider::where('branch_id', $branchId)->where('status', 'active')->get();

        return view('branch.online-requests', compact('requests', 'riders'));
    }

   public function assignAppointment(Request $request)
{
    $request->validate([
        'test_request_id' => 'required|exists:test_requests,id',
        'rider_id' => 'required|exists:riders,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required'
    ]);

    $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

    Appointment::create([
        'test_request_id' => $request->test_request_id,
        'rider_id' => $request->rider_id,
        'patient_id' => \App\Models\TestRequest::find($request->test_request_id)->patient_id,
        'branch_id' => auth('branch_admin')->user()->branch_id,
        'test_type' => 'online',
        'appointment_date' => $appointmentDateTime,
        'status' => 'scheduled',
        'visit_status' => 'pending'
    ]);

    return back()->with('success', 'Appointment assigned successfully!');
}

}

