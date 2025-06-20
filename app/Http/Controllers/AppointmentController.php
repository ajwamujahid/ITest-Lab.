<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\Test;

class AppointmentController extends Controller
{
    public function index(Request $request)
{
    $appointments = Appointment::with('branch')
        ->where('patient_id', auth()->id())
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->when($request->test_type, fn($q) => $q->where('test_type', $request->test_type))
        ->when($request->from && $request->to, function ($q) use ($request) {
            $q->whereBetween('appointment_date', [$request->from, $request->to]);
        })
        ->latest()
        ->paginate(10);

    return view('patients.appointments.index', compact('appointments'));
}
public function physicalTests()
{
    $patientId = Auth::guard('patient')->id();

    $physicalTestNames = ['X-Ray', 'MRI', 'CT Scan', 'Ultrasound'];

    $appointments = Appointment::with('patient')
        ->where('patient_id', $patientId)
        ->whereIn('test_type', $physicalTestNames)
        ->orderByDesc('created_at')
        ->get();

    return view('patients.appointments.physical', compact('appointments'));
}

} 