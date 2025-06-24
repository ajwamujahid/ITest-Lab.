@extends('layouts.master')

@section('title', 'Finance | Total Revenue')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-4">

    <h2 class="mb-4">Total Revenue Overview</h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" action="{{ url('finance/revenue') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
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
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-primary mt-md-0 mt-2"> Apply Filters</button>
            </div>
        </div>
    </form>

    {{-- 💰 Revenue Summary --}}
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card shadow border-0 bg-gradient bg-success text-white">
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">Total Revenue</h6>
                            <h3 class="fw-bold mt-2">PKR {{ number_format($totalRevenue) }}</h3>
                        </div>
                        <div>
                            <i class="bi bi-cash-stack fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📍 Revenue by Branch --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Revenue by Branch</div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Branch</th>
                        <th>Revenue (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($revenueByBranch as $branch => $amount)
                        <tr>
                            <td>{{ $branch }}</td>
                            <td class="fw-semibold">PKR {{ number_format($amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No data found for selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 🧪 Revenue by Test Type --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light fw-semibold">Revenue by Test Type</div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Test Type</th>
                        <th>Revenue (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($revenueByTest as $test => $amount)
                        <tr>
                            <td>{{ $test }}</td>
                            <td class="fw-semibold">PKR {{ number_format($amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No data found for selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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