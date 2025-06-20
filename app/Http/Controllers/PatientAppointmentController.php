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
    $branchId = auth()->user()->branch_id;

    $appointments = Appointment::where('branch_id', $branchId)
    ->with(['rider', 'testRequest']) // ✅ loading testRequest relationship
    ->latest()
    ->paginate(10);

    $tests = Test::all()->keyBy('id');
   // dd(Test::where('id', 1)->get());


    $riders = Rider::where('branch_id', $branchId)->get();
   // $tests = Test::where('branch_id', $branchId)->get()->keyBy('id');

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
