<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TestRequest;

class PatientReportController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();

        if (!$patient) {
            return redirect()->route('patient.login')->withErrors('Please log in first.');
        }

        // Get reports from test requests
        $testRequests = TestRequest::where('patient_id', $patient->id)
            ->whereNotNull('report_file_path')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patients.reports.index', compact('testRequests'));
    }
}
