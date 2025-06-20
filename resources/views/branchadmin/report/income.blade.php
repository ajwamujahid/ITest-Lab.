@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>📊 Income Report</h2>

    <form method="GET" class="row g-2">
        <div class="col-md-3">
            <label>From:</label>
            <input type="date" name="from" class="form-control" value="{{ \Carbon\Carbon::parse($from)->toDateString() }}">
        </div>
        <div class="col-md-3">
            <label>To:</label>
            <input type="date" name="to" class="form-control" value="{{ \Carbon\Carbon::parse($to)->toDateString() }}">
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered mt-4">
        
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient</th>
                <th>Test Type</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Amount (Rs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($income as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{ $item->patient->name ?? 'N/A' }}<br>
                        <small>{{ $item->patient->phone ?? '' }}</small>
                    </td>
                    <td>{{ $item->test_type }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->appointment_date)->format('d M Y') }}</td>
                    <td><span class="badge bg-success">{{ ucfirst($item->status) }}</span></td>
                    <td>Rs {{ number_format($item->amount) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No records found for selected range.</td>
                </tr>
            @endforelse
        </tbody>
        @if($income->count())
        <tfoot>
            <tr>
                <td colspan="5" class="text-end fw-bold">Total Income:</td>
                <td class="fw-bold text-success">Rs {{ number_format($total) }}</td>
            </tr>
            
        </tfoot>
        @endif
    </table>
</div>
@endsection
