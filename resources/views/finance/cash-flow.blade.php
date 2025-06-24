@extends('layouts.master')

@section('title', 'Finance | Cash Flow Statement')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-4">
    <h2 class="mb-4">Cash Flow Statement</h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" action="{{ url('finance/cash-flow') }}" class="row g-3 align-items-end mb-4">
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
            <select id="branch" name="branch" class="form-select select2">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
            
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Apply Filter</button>
        </div>
    </form>

    {{-- 📊 Summary Row (NO CARDS) --}}
    <div class="d-flex flex-wrap gap-4 justify-content-start mb-4">
        <div class="bg-success bg-opacity-10 border border-success rounded p-3 flex-fill">
            <h6 class="text-success">Total Inflows</h6>
            <h4 class="fw-bold text-success">PKR {{ number_format($inflows) }}</h4>
        </div>

        <div class="bg-danger bg-opacity-10 border border-danger rounded p-3 flex-fill">
            <h6 class="text-danger">Total Outflows</h6>
            <h4 class="fw-bold text-danger">PKR {{ number_format($outflows) }}</h4>
        </div>

        <div class="bg-primary bg-opacity-10 border border-primary rounded p-3 flex-fill">
            <h6 class="text-primary">Net Cash Flow</h6>
            <h4 class="fw-bold text-primary">PKR {{ number_format($netCashFlow) }}</h4>
        </div>
    </div>

    {{-- 🏢 Branch-Wise Cash Flow --}}
    <div class="card mb-4">
        <div class="card-header ">Branch-wise Cash Flow</div>
        <div class="card-body p-0">
            <table class="table  mb-0">
                <thead class="table-light">
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
                            $key = $branch->id;
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

    {{-- 💳 Transactions --}}
    <div class="row">
        {{-- Inflows --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header ">Inflow Transactions</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>Date</th><th>Patient</th><th>Amount</th><th>Branch</th></tr>
                        </thead>
                        <tbody>
                            @forelse($inflowTransactions as $trans)
                                <tr>
                                    <td>{{ $trans->test_date }}</td>
                                    <td>{{ $trans->patient_name }}</td>
                                    <td>{{ number_format($trans->amount_charged) }}</td>
                                    <td>{{ $trans->branch }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No inflow transactions.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Outflows --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light ">Outflow Transactions</div>
                <div class="card-body p-0">
                    <table class="table  mb-0">
                        <thead class="table-light">
                            <tr><th>Date</th><th>Description</th><th>Amount</th><th>Branch</th></tr>
                        </thead>
                        <tbody>
                            @forelse($outflowTransactions as $exp)
                                <tr>
                                    <td>{{ $exp->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $exp->description ?? 'N/A' }}</td>
                                    <td>{{ number_format($exp->amount) }}</td>
                                    <td>{{ $exp->branch->name ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No outflow transactions.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a branch",
            width: '100%',
            allowClear: true
        });
    });
</script>

@endpush