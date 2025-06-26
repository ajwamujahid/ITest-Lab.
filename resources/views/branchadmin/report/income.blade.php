@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2 class="mt-4 mb-3 text-primary">
        <i class="bx bx-coin-stack me-2"></i> Income Report
    </h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label class="form-label">From:</label>
            <input type="date" name="from" class="form-control"
                value="{{ \Carbon\Carbon::parse($from)->toDateString() }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">To:</label>
            <input type="date" name="to" class="form-control"
                value="{{ \Carbon\Carbon::parse($to)->toDateString() }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bx bx-filter-alt"></i> Filter
            </button>
        </div>
    </form>

    {{-- 📊 Income Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient</th>
                    <th>Test Type</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th class="text-end">Amount (Rs)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($income as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->patient->name ?? 'N/A' }}<br>
                            <small class="text-muted">{{ $item->patient->phone ?? 'N/A' }}</small>
                        </td>
                        <td>{{ ucfirst($item->test_type) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->appointment_date)->format('d M Y') }}</td>
                        <td><span class="badge bg-success">{{ ucfirst($item->status) }}</span></td>
                        <td class="text-end">Rs {{ number_format($item->amount) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                             No records found for selected date range.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($income->count())
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total Income:</td>
                        <td class="text-end fw-bold text-success">Rs {{ number_format($total) }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
