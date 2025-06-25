<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\TestRequest;
use App\Models\Rider;
use App\Models\Test;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    public function index(Request $request)
{
    $branchAdmin = auth('branchadmin')->user();

    if (!$branchAdmin || !$branchAdmin->branch_id) {
        abort(403, 'Unauthorized.');
    }

    $branch = \App\Models\Branch::find($branchAdmin->branch_id);
    if (!$branch) {
        abort(403, 'Branch not found.');
    }

    $statusFilter = $request->input('status');

    $testRequests = collect();  // initialize empty collection
    $appointments = collect();

    if ($statusFilter == 'pending' || $statusFilter == null) {
        // ✅ Show pending test requests
        $assignedTestRequestIds = Appointment::pluck('test_request_id')->filter()->toArray();

        $testRequests = TestRequest::where('branch', $branch->name)
            ->where('status', 'pending')
            ->where('test_type', 'online')
            ->whereNotIn('id', $assignedTestRequestIds)
            ->get();
    }

    if (in_array($statusFilter, ['scheduled', 'cancelled'])) {
        // ✅ Show appointments of that status
        $appointments = Appointment::with(['rider', 'testRequest'])
            ->where('branch_id', $branch->id)
            ->where('test_type', 'online')
            ->where('status', $statusFilter)
            ->latest()
            ->get();
    }

    $riders = Rider::where('branch_id', $branchAdmin->branch_id)->get();

    return view('branchadmin.patients.index', [
        'testRequests' => $testRequests,
        'appointments' => $appointments,
        'riders' => $riders,
        'statusFilter' => $statusFilter
    ]);
}


    public function assignAppointment(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'rider_id' => 'required|exists:riders,id',
        ]);
    
        $testRequest = TestRequest::find($id);
    
        if (!$testRequest) {
            return back()->with('error', 'Test request not found.');
        }
    
        if ($testRequest->test_type !== 'online') {
            return back()->with('error', 'Only online tests can be assigned.');
        }
    
        // ✅ Get branch ID
        $branch = \App\Models\Branch::where('name', $testRequest->branch)->first();
        if (!$branch) {
            return back()->with('error', 'Associated branch not found.');
        }
    
        // ✅ Create appointment
        Appointment::create([
            'test_request_id'   => $testRequest->id,
            'patient_id'        => $testRequest->patient_id,
            'branch_id'         => $branch->id,
            'rider_id'          => $request->rider_id,
            'appointment_date'  => $request->appointment_date,
            'status'            => 'scheduled',
            'test_type'         => 'online',
            'amount'            => $testRequest->total_amount ?? null,
        ]);
    
        return back()->with('success', 'Appointment assigned successfully.');
    }
   
    public function myAppointments()
    {
        $patientId = Auth::guard('patient')->id(); // Get logged-in patient ID
    
        $appointments = Appointment::with(['rider', 'testRequest', 'branch'])
            ->where('patient_id', $patientId)
            ->where('test_type', 'online')       // ✅ Only online tests
            ->whereNotNull('rider_id')           // ✅ Must be assigned to a rider
            ->latest()
            ->paginate(10);
    
        return view('patients.appointments', compact('appointments'));
    }
    
    
    public function trackRider(Appointment $appointment)
    {
        $rider = $appointment->rider;
        $branch = $appointment->branch;

        if (!$rider || !$branch) {
            return back()->with('error', 'Tracking information not available.');
        }

        return view('patients.track_rider', compact('rider', 'branch'));
    }

    public function riderAppointments()
    {
        $riderId = auth()->id();

        $appointments = Appointment::where('rider_id', $riderId)
            ->with(['testRequest', 'branch'])
            ->latest()
            ->paginate(10);

        return view('rider.assigned_patients', compact('appointments'));
    }

    public function sampleStatus()
    {
        $riderId = auth()->id();

        $appointments = Appointment::where('rider_id', $riderId)
            ->with(['testRequest', 'testRequest.patient', 'branch'])
            ->latest()
            ->paginate(10);

        return view('rider.sample_status', compact('appointments'));
    }

    public function trackPatient($id)
    {
        $appointment = Appointment::with(['testRequest', 'testRequest.patient'])->findOrFail($id);
        $rider = auth()->user();

        return view('rider.patient-tracking', [
            'patient' => $appointment->testRequest->patient,
            'rider' => $rider,
            'testRequest' => $appointment->testRequest,
        ]);
    }
}
