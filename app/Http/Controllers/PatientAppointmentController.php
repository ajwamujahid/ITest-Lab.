<?php

namespace App\Http\Controllers;

use App\Models\TestRequest;
use App\Models\Rider;
use App\Models\Test;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    // ✅ Branch admin view — list appointments & tests (only online)
    public function index()
    {
        $branchAdmin = auth('branchadmin')->user();

        if (!$branchAdmin || !$branchAdmin->branch_id) {
            abort(403, 'You must be logged in as a branch admin.');
        }

        $branchName = \App\Models\Branch::find($branchAdmin->branch_id)?->name;

        if (!$branchName) {
            abort(403, 'Branch not found.');
        }

        // Get appointments for this branch
        $appointments = Appointment::whereHas('testRequest', function ($query) use ($branchName) {
                $query->where('branch', $branchName);
            })
            ->whereIn('status', ['pending', 'scheduled'])
            ->with(['rider', 'testRequest'])
            ->latest()
            ->paginate(10);

        $riders = Rider::where('branch_id', $branchAdmin->branch_id)->get();

        // ✅ Get only online tests

        $branchId = auth('branchadmin')->user()->branch_id;
$tests = \App\Models\Test::where('branch_id', $branchId)->get()->keyBy('id');

        return view('branchadmin.patients.index', compact('appointments', 'riders', 'tests'));
    }

    // ✅ Assign or update appointment
    public function assignAppointment(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'rider_id' => 'required|exists:riders,id',
        ]);

        // Check if $id is Appointment ID or TestRequest ID
        $appointment = Appointment::find($id);

        if (!$appointment) {
            // If no appointment — treat $id as TestRequest ID and create new appointment
            $testRequest = TestRequest::findOrFail($id);

            // Check if TestRequest has online tests only
            $testIds = json_decode($testRequest->tests, true);
            $hasOnline = Test::whereIn('id', $testIds)->where('type', 'online')->exists();

            if (!$hasOnline) {
                return back()->with('error', 'Only online tests can be assigned.');
            }

            // Create new appointment
            $appointment = Appointment::create([
                'test_request_id' => $testRequest->id,
                'patient_id' => $testRequest->patient_id,
                'branch_id' => $testRequest->branch_id,
                'rider_id' => $request->rider_id,
                'appointment_date' => $request->appointment_date,
                'status' => 'scheduled',
            ]);
        } else {
            // If appointment exists, update it
            $appointment->update([
                'rider_id' => $request->rider_id,
                'appointment_date' => $request->appointment_date,
                'status' => 'scheduled',
            ]);
        }

        return back()->with('success', 'Appointment assigned successfully.');
    }

    // ✅ Optional: Rider view, patient view (unchanged)
    public function myAppointments()
    {
        $patientId = auth()->id();
        $appointments = Appointment::with(['rider', 'testRequest', 'branch'])->latest()->paginate(10);

        $tests = Test::where('type', 'online')->get()->keyBy('id');

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
        $rider = auth()->user();

        return view('rider.patient-tracking', [
            'patient' => $appointment->testRequest->patient,
            'rider' => $rider,
            'testRequest' => $appointment->testRequest,
        ]);
    }
}
