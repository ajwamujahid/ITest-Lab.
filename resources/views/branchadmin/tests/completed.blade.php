@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h3 class="mt-4"><i class="bx bx-check-circle  me-2"></i> Completed Tests</h3>


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
                    <td><span class="badge bg-success">{{ ucfirst($appointment->status) }}</span></td>
                    <td><span class="badge bg-secondary">{{ ucfirst($appointment->visit_status) }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No completed tests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>
@endsection
