<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestRequest;
use App\Models\Test;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PhysicalTestAppointmentController extends Controller
{
    public function index()
    {
        $manager = Auth::guard('manager')->user();

        // Define which tests are considered physical
        $physicalTestNames = ['MRI', 'CT Scan', 'X-Ray'];

        // Get test IDs for these physical tests
        $physicalTestIds = Test::whereIn('name', $physicalTestNames)->pluck('id')->toArray();

        // Fetch pending test requests for manager's branch
        $allRequests = TestRequest::where('branch', $manager->branch->name)
            ->where('status', 'pending')
            ->get();

        // Filter only physical test requests
        $testRequests = $allRequests->filter(function ($req) use ($physicalTestIds) {
            $testIds = is_array($req->tests) ? $req->tests : json_decode($req->tests, true);
            return count(array_intersect($testIds, $physicalTestIds)) > 0;
        });

        // All available tests for the manager's branch
        $availableTests = Test::where('branch_id', $manager->branch_id)->get();

        return view('manager.physical-tests.index', compact('testRequests', 'availableTests'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|numeric',
            'test_type' => 'required|string',
            'appointment_date' => 'required|date',
        ]);
    
        // 👇 Get test price from DB
        $test = Test::where('name', $request->test_type)->first();
    
        if (!$test) {
            return back()->with('error', 'Test not found!');
        }
    
        Appointment::create([
            'patient_id' => $request->patient_id,
            'branch_id' => Auth::guard('manager')->user()->branch_id,
            'test_type' => $request->test_type,
            'amount' => $test->price, // ✅ Automatically from DB
            'appointment_date' => $request->appointment_date,
            'status' => 'scheduled',
            'visit_status' => 'pending',
        ]);
    
        return back()->with('success', 'Appointment successfully assigned!');
    }
    public function assignedAppointments()
{
    $manager = Auth::guard('manager')->user();

    // Get physical tests assigned by this manager’s branch
    $physicalTestNames = ['MRI', 'CT Scan', 'X-Ray'];

    $appointments = Appointment::with('patient')
        ->where('branch_id', $manager->branch_id)
        ->whereIn('test_type', $physicalTestNames)
        ->orderByDesc('appointment_date')
        ->get();

    return view('manager.physical-tests.assigned', compact('appointments'));
}
public function updateVisitStatus(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'visit_status' => 'required|in:pending,visited',
    ]);

    $appointment = Appointment::find($request->appointment_id);
    $appointment->visit_status = $request->visit_status;
    $appointment->save();

    return back()->with('success', 'Visit status updated successfully.');
}

}
