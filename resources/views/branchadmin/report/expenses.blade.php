@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Expenses Report</h2>

    <form method="GET">
        <label>From:</label>
        <input type="date" name="from" value="{{ \Carbon\Carbon::parse($from)->toDateString() }}">
        <label>To:</label>
        <input type="date" name="to" value="{{ \Carbon\Carbon::parse($to)->toDateString() }}">
        <button type="submit">Filter</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Expense Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>Rs. {{ number_format($expense->amount) }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->expense_date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
