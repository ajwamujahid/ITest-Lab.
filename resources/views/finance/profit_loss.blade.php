@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Profit & Loss Statement</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('finance.profit-loss') }}" class="mb-4 row g-3 align-items-center">
        <div class="col-auto">
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $startDate) }}">
        </div>
        <div class="col-auto">
            <label for="end_date" class="form-label">End Date:</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $endDate) }}">
        </div>
        <div class="col-auto mt-4">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Summary -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h3>PKR {{ number_format($totalRevenue, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5>Total Expenses</h5>
                    <h3>PKR {{ number_format($totalExpenses, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white {{ $netProfit >= 0 ? 'bg-primary' : 'bg-warning' }} mb-3">
                <div class="card-body">
                    <h5>Net Profit / Loss</h5>
                    <h3>PKR {{ number_format($netProfit, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
