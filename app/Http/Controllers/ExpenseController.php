<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $branchId = auth('branchadmin')->user()->branch_id;
    
        // ✅ Use paginate() instead of get()
        $expenses = Expense::where('branch_id', $branchId)->paginate(10);
    
        return view('branchadmin.expenses.index', compact('expenses'));
    }
    public function create()
    {
        // Return create form view
        return view('branchadmin.expenses.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);
    
        Expense::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
            'branch_id' => auth('branchadmin')->user()->branch_id,
            'category' => $request->category,
        ]);
    
        return redirect()->route('branchadmin.expenses.index')->with('success', 'Expense added successfully.');
    }
    
}
