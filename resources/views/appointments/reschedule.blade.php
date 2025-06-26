@extends('layouts.branch-master')


@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary fw-bold">
        <i class="bx bx-calendar-edit me-2"></i> Reschedule Cancelled Appointments
    </h3>
    
{{-- /<p class="text-muted">Only appointments with <strong>status = cancelled</strong> are shown here.</p> --}}
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Old Date</th>
                <th>New Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'Unknown' }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>
                        <form method="POST" action="{{ route('appointments.reschedule.update', $appointment->id) }}">
                            @csrf
                            <input type="date" name="appointment_date" required class="form-control" />
                    </td>
                    <td>
                            <button class="btn btn-sm btn-primary" type="submit">Reschedule</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No pending appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
