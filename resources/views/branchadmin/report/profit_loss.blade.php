@extends('layouts.branch-master')

@section('content')
<div class="container py-4">

    {{-- 🧾 Page Title --}}
    <h2 class="mb-4 text-primary fw-bold">
        <i class="bx bx-line-chart me-2"></i> Profit & Loss Report
    </h2>

    {{-- 📅 Filter Form --}}
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label fw-semibold">From:</label>
            <input type="date" name="from" class="form-control" value="{{ $from->toDateString() }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">To:</label>
            <input type="date" name="to" class="form-control" value="{{ $to->toDateString() }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bx bx-filter-alt me-1"></i> Filter
            </button>
        </div>
    </form>

    {{-- 📊 Summary Section --}}
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light ">
                <h5 class="text-success fw-bold">Total Income</h5>
                <p class="fs-5 mb-0">Rs. {{ number_format($income) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light ">
                <h5 class="text-danger fw-bold">Total Expenses</h5>
                <p class="fs-5 mb-0">Rs. {{ number_format($expenses) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light ">
                <h5 class="text-primary fw-bold">Net Profit</h5>
                <p class="fs-5 mb-1">Rs. {{ number_format($profit) }}</p>
                <small class="text-muted">Expense %: {{ $expensePercentage }}%</small><br>
                <small class="text-muted">Profit Margin: {{ $profitMargin }}%</small>
            </div>
        </div>
    </div>

    {{-- 💰 Income Table --}}
    <h5 class="fw-bold text-success mb-3">Income Details</h5>
    <div class="table-responsive mb-5">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Invoice ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomeList as $inv)
                    <tr>
                        <td>{{ $inv->id }}</td>
                        <td>{{ $inv->created_at->toDateString() }}</td>
                        <td>Rs. {{ number_format($inv->amount) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No income records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 💸 Expenses Table --}}
    <h5 class="fw-bold text-danger mb-3">Expenses Details</h5>
    <div class="table-responsive mb-5">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Expense ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenseList as $exp)
                    <tr>
                        <td>{{ $exp->id }}</td>
                        <td>{{ $exp->expense_date }}</td>
                        <td>Rs. {{ number_format($exp->amount) }}</td>
                        <td>{{ $exp->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No expense records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex gap-3">
        <a href="{{ route('branch.profitloss.exportPdf', request()->query()) }}" class="btn btn-primary">
            <i class="bx bxs-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('branch.profitloss.exportExcel', request()->query()) }}" class="btn btn-success">
            <i class="bx bxs-file-export me-1"></i> Download Excel
        </a>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="bx bx-printer me-1"></i> Print
        </button>
    </div>
    
</div>
@endsection
