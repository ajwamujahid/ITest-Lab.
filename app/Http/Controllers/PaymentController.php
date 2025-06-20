<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Branch;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();

        // 🗓️ Filter by date range if provided
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('payment_date', [$request->from_date, $request->to_date]);
        }

        // 🔽 Get latest payments with pagination
        $payments = $query->latest()->paginate(20);

        return view('finance.payments', compact('payments'));
    }

}
