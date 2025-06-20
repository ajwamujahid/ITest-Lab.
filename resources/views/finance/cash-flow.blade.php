@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Cash Flow Statement</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ url('finance/cash-flow') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="branch" class="form-label">Branch</label>
                <select name="branch" class="form-select">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch }}" {{ $selectedBranch == $branch ? 'selected' : '' }}>
                            {{ $branch }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Total Inflows</h5>
                    <h3>PKR {{ number_format($inflows) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5>Total Outflows</h5>
                    <h3>PKR {{ number_format($outflows) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5>Net Cash Flow</h5>
                    <h3>PKR {{ number_format($netCashFlow) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Branch-Wise Cash Flow -->
    <div class="card mb-4">
        <div class="card-header">Cash Flow by Branch</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Inflows (PKR)</th>
                        <th>Outflows (PKR)</th>
                        <th>Net Cash Flow (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                    @php
                        // Use branch id or name as key depending on your array structure
                        $key = $branch->id; // or $branch->name if keys are names
                        $in = $inflowByBranch[$key] ?? 0;
                        $out = $outflowByBranch[$key] ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $branch->name }}</td>
                        <td>{{ number_format($in) }}</td>
                        <td>{{ number_format($out) }}</td>
                        <td>{{ number_format($in - $out) }}</td>
                    </tr>
                @endforeach
                
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transactions -->
    <div class="row">
        <!-- Inflows -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">Inflow Transactions</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr><th>Date</th><th>Patient</th><th>Amount</th><th>Branch</th></tr>
                        </thead>
                        <tbody>
                            @foreach($inflowTransactions as $trans)
                                <tr>
                                    <td>{{ $trans->test_date }}</td>
                                    <td>{{ $trans->patient_name }}</td>
                                    <td>{{ number_format($trans->amount_charged) }}</td>
                                    <td>{{ $trans->branch }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Outflows -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">Outflow Transactions</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr><th>Date</th><th>Description</th><th>Amount</th><th>Branch</th></tr>
                        </thead>
                        <tbody>
                            @foreach($outflowTransactions as $exp)
                                <tr>
                                    <td>{{ $exp->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $exp->description ?? 'N/A' }}</td>
                                    <td>{{ number_format($exp->amount) }}</td>
                                    <td>{{ $exp->branch }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
