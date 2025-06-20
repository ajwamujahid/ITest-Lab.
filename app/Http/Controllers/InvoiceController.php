<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Branch;

class InvoiceController extends Controller
{
    public function index(Request $request)
{
    $query = Invoice::with('branch');

    if ($request->branch_id) {
        $query->where('branch_id', $request->branch_id);
    }

    if ($request->from_date && $request->to_date) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    $invoices = $query->latest()->paginate(20);
    $branches = Branch::all();

    return view('finance.invoices', compact('invoices', 'branches'));
}

}
