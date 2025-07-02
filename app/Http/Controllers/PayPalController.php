<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\{Payer, Amount, Transaction, RedirectUrls, Payment};
use PayPal\Api\PaymentExecution;
use App\Models\Test;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Branch;
use App\Models\TestRequest;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET')
            )
        );

        $this->apiContext->setConfig([
            'mode' => env('PAYPAL_MODE'),
        ]);
    }

    public function payWithPayPal(Request $request)
    {
        $request->validate(['tests' => 'required|array']);

        $tests = Test::whereIn('id', $request->tests)->get();
        $total = $tests->sum('price');

        // Save session data
        session([
            'paypal_tests' => $request->tests,
            'paypal_branch' => $request->branch,
            'paypal_payment_method' => 'PayPal',
            'patient_info' => session('patient_info'),
        ]);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total); // assume prices in USD

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("iTestLab - Test Booking Payment");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success'))
            ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (\Exception $e) {
            return back()->with('error', 'PayPal Error: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $paymentId = $request->paymentId;
        $payerId = $request->PayerID;

        if (!$paymentId || !$payerId) {
            return redirect()->route('test.step1')->with('error', 'Payment failed.');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            // Create TestRequest & Invoice
            $info = session('patient_info');
            $tests = Test::whereIn('id', session('paypal_tests'))->get();
            $branch = session('paypal_branch');
            $total = $tests->sum('price');

            $testRequest = TestRequest::create([
                'patient_id' => Auth::guard('patient')->id(),
                'name' => $info['name'],
                'email' => $info['email'],
                'phone' => $info['phone'],
                'age' => $info['age'],
                'gender' => $info['gender'],
                'address' => $info['address'],
                'test_name' => $tests->pluck('name')->join(', '),
                'test_type' => $tests->pluck('type')->unique()->count() === 1 ? $tests->pluck('type')->first() : 'mixed',
                'branch' => $branch,
                'payment_method' => 'PayPal',
                'total_amount' => $total,
            ]);

            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'branch_id' => Branch::where('name', $branch)->value('id'),
                'amount' => $total,
                'test_request_id' => $testRequest->id,
            ]);

            session()->forget(['patient_info', 'paypal_tests', 'paypal_branch']);

            return redirect()->route('test.invoice', $invoice->id)->with('success', 'Payment successful.');
        }

        return redirect()->route('test.step1')->with('error', 'Payment was not approved.');
    }

    public function cancel()
    {
        return redirect()->route('test.step1')->with('error', 'Payment was canceled.');
    }
}
