@extends('layouts.master')

@section('title', 'Finance | Profit & Loss Statement')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Profit & Loss Statement</h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" action="{{ route('finance.profit-loss') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-2">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $startDate) }}">
        </div>
        <div class="col-md-2">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $endDate) }}">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary  mt-2">Apply Filter</button>
        </div>
    </form>

    {{-- 📊 Summary Table --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th style="width: 50px;">#</th>
                    <th>Metric</th>
                    <th>Amount (PKR)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>1</td>
                    <td class="text-start">Total Revenue</td>
                    <td class="fw-bold text-success">PKR {{ number_format($totalRevenue, 2) }}</td>
                    <td><i class="bi bi-bar-chart-fill fs-4 text-success"></i></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-start">Total Expenses</td>
                    <td class="fw-bold text-danger">PKR {{ number_format($totalExpenses, 2) }}</td>
                    <td><i class="bi bi-receipt-cutoff fs-4 text-danger"></i></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-start">Net {{ $netProfit >= 0 ? 'Profit' : 'Loss' }}</td>
                    <td class="fw-bold {{ $netProfit >= 0 ? 'text-primary' : 'text-warning' }}">
                        PKR {{ number_format($netProfit, 2) }}
                    </td>
                    <td>
                        <i class="bi bi-graph-{{ $netProfit >= 0 ? 'up' : 'down' }} fs-4 {{ $netProfit >= 0 ? 'text-primary' : 'text-warning' }}"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
