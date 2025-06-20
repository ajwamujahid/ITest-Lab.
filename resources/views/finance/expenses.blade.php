@extends('layouts.master')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Total Expenses</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ url('finance/expenses') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fs-14 text-dark">Branch <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-control" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('branch_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
     
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Summary -->
    <div class="mb-4">
        <div class="card bg-light p-3">
            <h4>Total Expenses: <span class="text-danger">PKR {{ number_format($totalExpenses, 2) }}</span></h4>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="card">
        <div class="card-header">
            Expenses List
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Amount (PKR)</th>
                        <th>Date</th>
                        <th>Branch ID</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage() }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $expense->branch_id }}</td>
                        <td>{{ $expense->category ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No expenses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $expenses->withQueryString()->links() }}
    </div>
</div>
@endsection
