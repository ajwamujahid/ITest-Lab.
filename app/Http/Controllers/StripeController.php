<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate(['tests' => 'required|array']);
        $tests = Test::whereIn('id', $request->tests)->get();
        $amount = $tests->sum('price') * 100;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'pkr',
        ]);

        return response()->json(['clientSecret' => $intent->client_secret]);
    }
}
