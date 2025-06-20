@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Branch Income</h2>
    <a href="{{ route('income.create') }}" class="btn btn-primary mb-3">+ Add Income</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Source</th>
                <th>Amount</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($incomes as $income)
            <tr>
                <td>{{ $income->income_date }}</td>
                <td>{{ $income->source }}</td>
                <td>Rs. {{ number_format($income->amount, 2) }}</td>
                <td>{{ $income->note }}</td>
                <td>
                    <a href="{{ route('income.edit', $income->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('income.destroy', $income->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this income?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
