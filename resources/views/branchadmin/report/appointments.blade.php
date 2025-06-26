@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2 class="mt-4 mb-3 text-primary fw-bold">
        <i class="bx bx-calendar me-2"></i> Appointments Report
    </h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" class="row g-3 align-items-end mb-4">
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

    {{-- 📋 Appointments Table --}}
    <div class="table-responsive mb-5">
        <table class="table table-bordered ">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Test Type</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient_id ?? 'N/A' }}</td>
                        <td class="text-capitalize">{{ $appointment->test_type ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y, h:i A') }}</td>
                        <td>
                            <span class="badge 
                                @if($appointment->status == 'scheduled') bg-warning
                                @elseif($appointment->status == 'completed') bg-success
                                @elseif($appointment->status == 'cancelled') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                             No appointments found for the selected date range.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
