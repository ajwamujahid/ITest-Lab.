@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2 class="mt-4 mb-3 text-primary fw-bold">
        <i class="bx bx-wallet me-2"></i> Expenses Report
    </h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label class="form-label">From:</label>
            <input type="date" name="from" class="form-control"
                   value="{{ \Carbon\Carbon::parse($from)->toDateString() }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">To:</label>
            <input type="date" name="to" class="form-control"
                   value="{{ \Carbon\Carbon::parse($to)->toDateString() }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bx bx-filter-alt"></i> Filter
            </button>
        </div>
    </form>

    {{-- 📄 Expenses Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Amount (Rs)</th>
                    <th>Description</th>
                    <th>Expense Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $expense->id }}</td>
                        <td class="text-end">Rs. {{ number_format($expense->amount) }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No expenses found in the selected range.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
