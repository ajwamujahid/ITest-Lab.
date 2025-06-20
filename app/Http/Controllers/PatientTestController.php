<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Test;
use App\Models\Branch;
use App\Models\TestRequest;
use Illuminate\Support\Facades\Auth;

class PatientTestController extends Controller
{
    /**
     * Step 1: Show patient info form.
     */
    public function step1()
    {
        return view('patients.test-step1');
    }

    /**
     * Handle Step 1 form submit: Save info to session.
     */
    public function storeStep1(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'address' => 'required',
        ]);

        session([
            'patient_info' => $request->only(
                'name', 'email', 'phone', 'age', 'gender', 'address'
            )
        ]);

        return redirect()->route('test.step2');
    }

    /**
     * Step 2: Show tests grouped by branch.
     */
    public function step2()
    {
        $branches = Branch::all();
        $testsGrouped = Test::with('branch')->get()->groupBy('branch.name');

        return view('patients.test-step2', compact('branches', 'testsGrouped'));
    }

    /**
     * Store test request (for multi-step).
     */
    public function store(Request $request)
    {
        $request->validate([
            'tests' => 'required|array',
            'branch' => 'required',
            'payment_method' => 'required',
        ]);

        $patientId = Auth::guard('patient')->id();
        if (!$patientId) {
            abort(403, 'Patient not authenticated.');
        }

        $info = session('patient_info');
        $tests = Test::whereIn('id', $request->tests)->get();
        $total = $tests->sum('price');

        // ✅ Store as ARRAY — Laravel will cast it to JSON for DB:
        TestRequest::create([
            'patient_id' => $patientId,
            'name' => $info['name'],
            'email' => $info['email'],
            'phone' => $info['phone'],
            'age' => $info['age'],
            'gender' => $info['gender'],
            'address' => $info['address'],
            'tests' => $tests->pluck('id')->toArray(), // ✅ no json_encode here!
            'branch' => $request->branch,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
        ]);

        session()->forget('patient_info');

        return redirect()->route('test.step1')
            ->with('success', 'Test request submitted successfully!');
    }

    /**
     * Store final step + create invoice.
     */
    public function postFinalStep(Request $request)
    {
        $request->validate([
            'tests' => 'required|array',
            'branch' => 'required',
            'payment_method' => 'required',
        ]);

        $patientId = Auth::guard('patient')->id();
        if (!$patientId) {
            abort(403, 'Patient not authenticated.');
        }

        $info = session('patient_info');
        $tests = Test::whereIn('id', $request->tests)->get();
        $total = $tests->sum('price');

        // ✅ Store as ARRAY
        $testRequest = TestRequest::create([
            'patient_id' => $patientId,
            'name' => $info['name'],
            'email' => $info['email'],
            'phone' => $info['phone'],
            'age' => $info['age'],
            'gender' => $info['gender'],
            'address' => $info['address'],
          'tests' => $tests->pluck('id')->toArray(),
            'branch' => $request->branch,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
        ]);

        // ✅ Create invoice linked to test request
        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'branch_id' => Branch::where('name', $request->branch)->value('id'),
            'amount' => $total,
            'test_request_id' => $testRequest->id,
        ]);

        session()->forget('patient_info');

        return redirect()->route('test.invoice', $invoice->id);
    }

    /**
     * Show patient invoice.
     */
    public function showInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);

        $testRequest = $invoice->testRequest ?? TestRequest::where('total_amount', $invoice->amount)
            ->where('branch', Branch::find($invoice->branch_id)->name)
            ->latest()
            ->first();

        $selectedTests = collect();
        if ($testRequest && is_array($testRequest->tests)) {
            // ✅ no json_decode needed
            $selectedTests = Test::whereIn('id', $testRequest->tests)->get();
        }

        return view('patients.invoice', [
            'invoice' => $invoice,
            'patient' => $testRequest,
            'selectedTests' => $selectedTests,
        ]);
    }
}
