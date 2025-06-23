<?php

namespace App\Http\Controllers;

use App\Models\TestRequest;
use App\Models\Rider;
use App\Models\Test;
use App\Models\Appointment; // 🔁 Import at the top
use Illuminate\Http\Request;


class PatientAppointmentController extends Controller
{
    public function index()
{
    $branchAdmin = auth('branchadmin')->user();

    if (!$branchAdmin || !$branchAdmin->branch_id) {
        abort(403, 'You must be logged in as a branch admin.');
    }

    // Get the branch name from branch ID
    $branchName = \App\Models\Branch::find($branchAdmin->branch_id)?->name;

    if (!$branchName) {
        abort(403, 'Branch not found.');
    }

    // Fetch only the appointments where the test request's branch name matches
    $appointments = \App\Models\Appointment::whereHas('testRequest', function ($query) use ($branchName) {
        $query->where('branch', $branchName);
    })
    ->with(['rider', 'testRequest'])
    ->latest()
    ->paginate(10);

    $tests = \App\Models\Test::all()->keyBy('id');
    $riders = \App\Models\Rider::where('branch_id', $branchAdmin->branch_id)->get();

    return view('branchadmin.patients.index', compact('appointments', 'riders', 'tests'));
}

    
public function assignAppointment(Request $request, $id)
{
    $request->validate([
        'appointment_date' => 'required|date',
        'rider_id' => 'required|exists:riders,id',
    ]);

    // Step 1: Get the appointment by ID
    $appointment = Appointment::findOrFail($id);

    // Step 2: Get the related TestRequest
    $testRequest = $appointment->testRequest;

    if (!$testRequest || !$testRequest->patient_id) {
        return back()->with('error', 'Patient info not found.');
    }

    $appointment->update([
        'patient_id'       => $testRequest->patient_id,
        'rider_id'         => $request->rider_id,
        'appointment_date' => $request->appointment_date,
        'status'           => 'scheduled',
    ]);
    
    

    return back()->with('success', 'Appointment assigned successfully.');
}

public function createAppointment(Request $request, $testRequestId)
{
    $request->validate([
        'appointment_date' => 'required|date',
        'rider_id' => 'required|exists:riders,id',
    ]);

    $testRequest = TestRequest::findOrFail($testRequestId);

    if (!$testRequest->patient_id || !$testRequest->branch_id) {
        return back()->with('error', 'Invalid test request.');
    }

    if ($testRequest->appointment) {
        return back()->with('error', 'Appointment already exists.');
    }

    Appointment::create([
        'test_request_id' => $testRequest->id,
        'patient_id' => $testRequest->patient_id,
        'branch_id' => $testRequest->branch_id,
        'rider_id' => $request->rider_id,
        'appointment_date' => $request->appointment_date,
        'status' => 'scheduled',
    ]);

    return back()->with('success', 'Appointment assigned.');
}

    public function myAppointments()
    {
        $patientId = auth()->id();
        $appointments = Appointment::with(['rider', 'testRequest', 'branch'])->latest()->paginate(10);

    
    $tests = \App\Models\Test::all()->keyBy('id'); // ✅ get all test names
    
    
        return view('patients.appointments', compact('appointments', 'tests'));
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
    $testRequest = $appointment->testRequest;
    $patient = $testRequest->patient;

    // Assuming rider is the logged-in user
    $rider = auth()->user();
    return view('rider.patient-tracking', [
        'patient' => $appointment->testRequest->patient,
        'rider' => auth()->user(), // or however rider info is fetched
        'testRequest' => $appointment->testRequest,
    ]);
    
   // return view('rider.patient-tracking', compact('appointment', 'testRequest', 'patient', 'rider'));
}

    


    
}
