<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\TestRequest;
use Illuminate\Support\Facades\Auth;

class PatientTestController extends Controller
{
    public function step1()
    {
        return view('patients.test-step1');
    }

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

    session(['patient_info' => $request->only('name', 'email', 'phone', 'age', 'gender', 'address')]);

    return redirect()->route('test.step2');
}

    public function step2()
    {
        if (!session('patient_info')) return redirect()->route('test.step1');

        $branches = Branch::all();
        $testsGrouped = Test::with('branch')->get()->groupBy('branch.name');

        return view('patients.test-step2', compact('branches', 'testsGrouped'));
    }

    public function postFinalStep(Request $request)
    {
        $request->validate([
            'tests' => 'required|array',
            'branch' => 'required',
            'payment_method' => 'required',
        ]);
    
        if ($request->payment_method === 'Stripe') {
            session([
                'stripe_tests' => $request->tests,
                'stripe_branch' => $request->branch,
            ]);
            return response()->json(['status' => 'session saved']);
        }
    
        $invoice = $this->createTestAndInvoice($request, $request->tests, $request->branch, 'Cash');
        return redirect()->route('test.invoice', $invoice->id);
    }
    
    public function stripeSuccess(Request $request)
    {
        $info = session('patient_info');
        $tests = session('stripe_tests');
        $branch = session('stripe_branch');
    
        $patientId = Auth::guard('patient')->id();
        if (!$patientId || !$info || !$tests || !$branch) {
            return response()->json(['error' => 'Session expired or missing info'], 403);
        }
    
        $invoice = $this->createTestAndInvoice($request, $tests, $branch, 'Stripe');
    
        return response()->json(['invoice_id' => $invoice->id]);
    }
    private function createTestAndInvoice($request, $testsIds, $branchName, $paymentMethod)
{
    $patientId = Auth::guard('patient')->id();
    $info = session('patient_info');

    $tests = Test::whereIn('id', $testsIds)->get();
    $total = $tests->sum('price');

    $testRequest = TestRequest::create([
        'patient_id' => $patientId,
        'name' => $info['name'],
        'email' => $info['email'],
        'phone' => $info['phone'],
        'age' => $info['age'],
        'gender' => $info['gender'],
        'address' => $info['address'],
        'test_name' => $tests->pluck('name')->join(', '),
        'test_type' => $tests->pluck('type')->unique()->count() === 1 ? $tests->first()->type : 'mixed',
        'branch' => $branchName,
        'payment_method' => $paymentMethod,
        'total_amount' => $total,
    ]);

    $invoice = Invoice::create([
        'invoice_number' => 'INV-' . strtoupper(uniqid()),
        'branch_id' => Branch::where('name', $branchName)->value('id'),
        'amount' => $total,
        'test_request_id' => $testRequest->id,
    ]);

    session()->forget(['patient_info', 'stripe_tests', 'stripe_branch']);

    return $invoice;
}
public function showInvoice($id)
{
    $invoice = Invoice::with('testRequest')->findOrFail($id);
    $testRequest = $invoice->testRequest;

    // if (!$testRequest) {
    //     abort(404, 'Test request not found for invoice.');
    // }

    $branch = Branch::find($testRequest->branch_id);

    $tests = explode(', ', $testRequest->test_name ?? '');
    $testCount = count($tests) ?: 1;

    $selectedTests = collect($tests)->map(function ($name) use ($testRequest, $invoice, $testCount) {
        return [
            'name' => $name,
            'type' => $testRequest->test_type ?? 'N/A',
            'price' => round($invoice->amount / $testCount, 2),
        ];
    });

    return view('patients.invoice', [
        'invoice' => $invoice,
        'branch' => $branch,
        'patient' => $testRequest,
        'selectedTests' => $selectedTests,
    ]);
}
}