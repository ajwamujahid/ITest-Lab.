@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Total Revenue</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ url('finance/revenue') }}" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="start_date" class="col-form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-auto">
                <label for="end_date" class="col-form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-auto">
                <label for="branch" class="col-form-label">Branch:</label>
                <select id="branch" name="branch" class="form-select">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto mt-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Summary Boxes -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h3>PKR {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue By Branch -->
    <div class="card mb-4">
        <div class="card-header">Revenue by Branch</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Branch</th><th>Revenue (PKR)</th></tr>
                </thead>
                <tbody>
                    @forelse($revenueByBranch as $branch => $amount)
                        <tr>
                            <td>{{ $branch }}</td>
                            <td>{{ number_format($amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No data found for selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Revenue By Test Type -->
    <div class="card mb-4">
        <div class="card-header">Revenue by Test Type</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Test Type</th><th>Revenue (PKR)</th></tr>
                </thead>
                <tbody>
                    @forelse($revenueByTest as $test => $amount)
                        <tr>
                            <td>{{ $test }}</td>
                            <td>{{ number_format($amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No data found for selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
