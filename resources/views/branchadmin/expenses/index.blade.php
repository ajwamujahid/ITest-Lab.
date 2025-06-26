@extends('layouts.branch-master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary fw-bold">
        <i class="bi bi-wallet2 me-2"></i> My Expenses
    </h3>
    

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <a href="{{ route('branchadmin.expenses.create') }}" class="btn btn-primary mb-3">➕ Add New Expense</a>

    @if($expenses->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>Rs. {{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->description ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}</td>
                        <td>{{ $expense->category ?? '-' }}</td>
                        <td>
                            {{-- Optional: Add Edit/Delete later --}}
                            {{-- <a href="#" class="btn btn-sm btn-info">Edit</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $expenses->links() }} {{-- pagination --}}
    @else
        <p>No expenses found.</p>
    @endif
</div>
@endsection
