<!-- resources/views/finance/budget.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Budget Management</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Department</th>
                <th>Allocated Amount (PKR)</th>
                <th>Used Amount (PKR)</th>
                <th>Remaining (PKR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($budgets as $budget)
                <tr>
                    <td>{{ $budget->department }}</td>
                    <td>{{ number_format($budget->allocated_amount) }}</td>
                    <td>{{ number_format($budget->used_amount) }}</td>
                    <td>{{ number_format($budget->allocated_amount - $budget->used_amount) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
