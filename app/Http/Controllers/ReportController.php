<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function uploadForm()
    {
        $patients = Patient::select('id', 'name')->get();
        return view('manager.reports.upload', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'test_type'    => 'required|string|max:255',
            'report_file'  => 'required|mimes:pdf,jpg,png|max:2048',
        ]);
    
        // Upload report
        $path = $request->file('report_file')->store('reports', 'public');
    
        // Try to find an unreported test request for this patient
        $testRequest = \App\Models\TestRequest::where('patient_id', $request->patient_id)
            ->whereNull('report_file_path')
            ->latest()
            ->first();
    
        // Save report entry
        Report::create([
            'patient_id'      => $request->patient_id,
            'test_request_id' => optional($testRequest)->id,  // can be null
            'test_type'       => $request->test_type,
            'notes'           => $request->notes,
            'report_file'     => $path,
            'uploaded_by'     => auth('manager')->id(),
        ]);
    
        // Optionally update the test request to mark as reported
        if ($testRequest) {
            $testRequest->report_file_path = $path;
            $testRequest->save();
        }
    
        return redirect()->back()->with('success', 'Report uploaded successfully.');
    }
    
}
