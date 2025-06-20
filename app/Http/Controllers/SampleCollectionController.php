<?php
namespace App\Http\Controllers;

use App\Models\SampleCollection;
use App\Models\Patient;
use App\Models\Rider;
use Illuminate\Http\Request;

class SampleCollectionController extends Controller
{
    public function create()
    {
        $patients = Patient::all();
        $riders = Rider::all();
        return view('manager.sample.assign', compact('patients', 'riders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'rider_id' => 'required|exists:riders,id',
            'test_type' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        SampleCollection::create([
            'patient_id' => $request->patient_id,
            'rider_id' => $request->rider_id,
            'test_type' => $request->test_type,
            'address' => $request->address,
            'status' => 'pending',
            'assigned_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Sample collection assigned successfully.');
    }
}
