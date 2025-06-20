@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>⏳ Pending Tests</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Test Type</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Visit</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->test_type }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td><span class="badge bg-warning text-dark">{{ ucfirst($appointment->status) }}</span></td>
                    <td><span class="badge bg-secondary">{{ ucfirst($appointment->visit_status) }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No pending tests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>
@endsection
