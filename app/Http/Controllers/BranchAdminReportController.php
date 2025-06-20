<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Expense;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\TestRequest;

class BranchAdminReportController extends Controller
{
//     public function index()
// {
//     // Yahan apni reports dashboard ki logic likho
//     return view('branchadmin.report.index'); 
// }

public function profitLoss(Request $request)
{
    $branchId = auth()->user()->branch_id;

    // Date range handle karo
    $from = $request->from ? Carbon::parse($request->from) : Carbon::now()->startOfMonth();
    $to = $request->to ? Carbon::parse($request->to) : Carbon::now()->endOfMonth();

    // Income summary
    $income = Invoice::where('branch_id', $branchId)
        ->whereBetween('created_at', [$from, $to])
        ->sum('amount');

    // Expenses summary
    $expenses = Expense::where('branch_id', $branchId)
        ->whereBetween('expense_date', [$from, $to])
        ->sum('amount');

    // Profit
    $profit = $income - $expenses;

    // Detailed lists
    $incomeList = Invoice::where('branch_id', $branchId)
        ->whereBetween('created_at', [$from, $to])
        ->get();

    $expenseList = Expense::where('branch_id', $branchId)
        ->whereBetween('expense_date', [$from, $to])
        ->get();

    // Percentages
    $expensePercentage = $income > 0 ? round(($expenses / $income) * 100, 2) : 0;
    $profitMargin = $income > 0 ? round(($profit / $income) * 100, 2) : 0;

    return view('branchadmin.report.profit_loss', compact(
        'income', 'expenses', 'profit',
        'incomeList', 'expenseList',
        'expensePercentage', 'profitMargin',
        'from', 'to'
    ));
}

public function incomereport(Request $request)
{
    $branchId = auth('branchadmin')->user()->branch_id;

    $from = $request->input('from', now()->startOfMonth()->toDateString());
    $to = $request->input('to', now()->endOfMonth()->toDateString());

    $income = \App\Models\Appointment::with('patient')
        ->where('branch_id', $branchId)
        ->whereBetween('appointment_date', [$from, $to])
        ->where('status', 'completed')
        ->get();

    $total = $income->sum('amount');
    // dd(
    //     \App\Models\Appointment::where('branch_id', $branchId)
    //         ->select('id', 'appointment_date', 'status', 'amount')
    //         ->orderByDesc('appointment_date')
    //         ->get()
    // );
    
    return view('branchadmin.report.income', compact('income', 'from', 'to', 'total'));
}


    public function expenses(Request $request)
    {
        $branchId = auth()->user()->branch_id;
        $from = $request->from ?? now()->startOfMonth();
        $to = $request->to ?? now()->endOfMonth();

        $expenses = Expense::where('branch_id', $branchId) // ✅ sahi column name
        ->whereBetween('expense_date', [$from, $to])
        ->get();
    
        return view('branchadmin.report.expenses', compact('expenses', 'from', 'to'));
    }

    public function appointments(Request $request)
    {
        $branchId = auth()->user()->branch_id;
        $from = $request->from ?? now()->startOfMonth();
        $to = $request->to ?? now()->endOfMonth();

        $appointments = Appointment::where('branch_id', $branchId)
            ->whereBetween('appointment_date', [$from, $to])
            ->get();

        return view('branchadmin.report.appointments', compact('appointments', 'from', 'to'));
    }
}
