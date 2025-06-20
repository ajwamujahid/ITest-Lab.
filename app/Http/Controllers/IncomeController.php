<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $branchAdmin = Auth::guard('branchadmin')->user();

        if (!$branchAdmin) {
            return redirect()->route('login')->withErrors(['error' => 'Branch Admin not authenticated']);
        }

        $incomes = Income::where('branch_id', $branchAdmin->branch_id)->get();

        return view('branchadmin.income.index', compact('incomes'));
    }

    public function create()
    {
        return view('branchadmin.income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'income_date' => 'required|date',
        ]);

        $branchAdmin = Auth::guard('branchadmin')->user();

        if (!$branchAdmin) {
            return back()->withErrors(['error' => 'Branch Admin not authenticated']);
        }

        Income::create([
            'branch_id'   => $branchAdmin->branch_id,
            'source'      => $request->source,
            'amount'      => $request->amount,
            'income_date' => $request->income_date,
            'note'        => $request->note,
        ]);

        return redirect()->route('income.index')->with('success', 'Income added successfully!');
    }

    public function edit($id)
    {
        $branchAdmin = Auth::guard('branchadmin')->user();

        if (!$branchAdmin) {
            return redirect()->route('login')->withErrors(['error' => 'Branch Admin not authenticated']);
        }

        $income = Income::where('branch_id', $branchAdmin->branch_id)->findOrFail($id);

        return view('branchadmin.income.edit', compact('income'));
    }

    public function update(Request $request, $id)
    {
        $branchAdmin = Auth::guard('branchadmin')->user();

        if (!$branchAdmin) {
            return redirect()->route('login')->withErrors(['error' => 'Branch Admin not authenticated']);
        }

        $income = Income::where('branch_id', $branchAdmin->branch_id)->findOrFail($id);

        $request->validate([
            'source'      => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'income_date' => 'required|date',
        ]);

        $income->update([
            'source'      => $request->source,
            'amount'      => $request->amount,
            'income_date' => $request->income_date,
            'note'        => $request->note,
        ]);

        return redirect()->route('income.index')->with('success', 'Income updated.');
    }

    public function destroy($id)
    {
        $branchAdmin = Auth::guard('branchadmin')->user();

        if (!$branchAdmin) {
            return redirect()->route('login')->withErrors(['error' => 'Branch Admin not authenticated']);
        }

        $income = Income::where('branch_id', $branchAdmin->branch_id)->findOrFail($id);
        $income->delete();

        return redirect()->route('income.index')->with('success', 'Income deleted.');
    }
    
}
