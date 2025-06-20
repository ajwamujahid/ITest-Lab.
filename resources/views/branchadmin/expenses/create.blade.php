@extends('layouts.branch-master')

@section('content')
<div class="container mt-4">
    <h2>Add New Expense</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('branchadmin.expenses.store') }}">
        @csrf

        <div class="mb-3">
            <label for="amount" class="form-label">Amount (Rs.)</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <input type="text" name="description" class="form-control">
        </div>

        <div class="mb-3">
            <label for="expense_date" class="form-label">Expense Date</label>
            <input type="date" name="expense_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category (Optional)</label>
            <input type="text" name="category" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">💾 Save Expense</button>
        <a href="{{ route('branchadmin.expenses.index') }}" class="btn btn-secondary">🔙 Back</a>
    </form>
</div>
@endsection
