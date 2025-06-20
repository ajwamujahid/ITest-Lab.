<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\RevenueRecord;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function totalRevenue(Request $request)
    {
        $query = RevenueRecord::query();

        if ($request->has('start_date')) {
            $query->whereDate('test_date', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('test_date', '<=', $request->end_date);
        }

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch', $request->branch); // ✅ fixed
        }

        $totalRevenue = $query->sum('amount_charged');

        $revenueByBranch = DB::table('revenue_records')
            ->select('branch')
            ->selectRaw('SUM(amount_charged) as total')
            ->groupBy('branch')
            ->pluck('total', 'branch'); // ✅ fixed

        $revenueByTest = $query->select('test_name')
            ->selectRaw('SUM(amount_charged) as total')
            ->groupBy('test_name')
            ->pluck('total', 'test_name');

        $branches = RevenueRecord::distinct()->pluck('branch'); // ✅ fixed

        return view('finance.revenue', compact(
            'totalRevenue', 'revenueByBranch', 'revenueByTest', 'branches'
        ));
    }

    public function showRevenue(Request $request)
    {
        $query = DB::table('revenue_records');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('test_date', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date) {
            $query->where('test_date', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->where('test_date', '<=', $request->end_date);
        }

        if ($request->branch) {
            $query->where('branch', $request->branch); // ✅ fixed
        }

        $totalRevenue = $query->sum('amount_charged');

        $revenueByBranch = (clone $query)
            ->select('branch', DB::raw('SUM(amount_charged) as total')) // ✅ fixed
            ->groupBy('branch')
            ->pluck('total', 'branch');

        $revenueByTest = (clone $query)
            ->select('test_name', DB::raw('SUM(amount_charged) as total'))
            ->groupBy('test_name')
            ->pluck('total', 'test_name');

        $branches = DB::table('revenue_records')->distinct()->pluck('branch'); // ✅ fixed

        return view('finance.revenue', compact('totalRevenue', 'revenueByBranch', 'revenueByTest', 'branches'));
    }

    public function expenses(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('start_date')) {
            $query->whereDate('expense_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('expense_date', '<=', $request->end_date);
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        $expenses = $query->orderByRaw("
            CASE 
                WHEN expense_date = CURDATE() - INTERVAL 1 DAY THEN 1
                WHEN expense_date = CURDATE() THEN 2
                ELSE 3
            END
        ")->orderBy('expense_date', 'desc')->paginate(15);

        $totalExpenses = $query->sum('amount');

        $branches = \App\Models\Branch::whereIn(
            'id',
            Expense::select('branch_id')->distinct()
        )->pluck('name', 'id');

        return view('finance.expenses', compact('expenses', 'totalExpenses', 'branches'));
    }

    public function profitLoss(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $revenueQuery = RevenueRecord::query();
        $expenseQuery = Expense::query();

        if ($startDate) {
            $revenueQuery->whereDate('test_date', '>=', $startDate);
            $expenseQuery->whereDate('expense_date', '>=', $startDate);
        }

        if ($endDate) {
            $revenueQuery->whereDate('test_date', '<=', $endDate);
            $expenseQuery->whereDate('expense_date', '<=', $endDate);
        }

        $totalRevenue = $revenueQuery->sum('amount_charged');
        $totalExpenses = $expenseQuery->sum('amount');

        $netProfit = $totalRevenue - $totalExpenses;

        return view('finance.profit_loss', compact('totalRevenue', 'totalExpenses', 'netProfit', 'startDate', 'endDate'));
    }

    public function budget()
    {
        $budgets = Budget::all();
        return view('finance.budget', compact('budgets'));
    }

    public function cashFlow(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->endOfMonth()->toDateString();

        $branches = RevenueRecord::select('branch')->distinct()->pluck('branch') // ✅ fixed
            ->merge(
                Expense::select('branch_id')->distinct()->pluck('branch_id')
            )->unique();

        $selectedBranch = $request->branch;

        $revenueQuery = RevenueRecord::whereBetween('test_date', [$startDate, $endDate]);
        $expenseQuery = Expense::whereBetween('expense_date', [$startDate, $endDate]);

        if ($selectedBranch) {
            $revenueQuery->where('branch', $selectedBranch); // ✅ fixed
            $expenseQuery->where('branch_id', $selectedBranch);
        }

        $inflows = $revenueQuery->sum('amount_charged');
        $outflows = $expenseQuery->sum('amount');
        $netCashFlow = $inflows - $outflows;

        $inflowByBranch = RevenueRecord::whereBetween('test_date', [$startDate, $endDate])
            ->select('branch', DB::raw('SUM(amount_charged) as total_inflow')) // ✅ fixed
            ->groupBy('branch')
            ->pluck('total_inflow', 'branch');

        $outflowByBranch = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->select('branch_id', DB::raw('SUM(amount) as total_outflow'))
            ->groupBy('branch_id')
            ->pluck('total_outflow', 'branch_id');

        $inflowTransactions = $revenueQuery->get();
        $outflowTransactions = $expenseQuery->get();

        return view('finance.cash-flow', compact(
            'startDate', 'endDate', 'selectedBranch', 'branches',
            'inflows', 'outflows', 'netCashFlow',
            'inflowByBranch', 'outflowByBranch',
            'inflowTransactions', 'outflowTransactions'
        ));
    }
}
