@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>📋 All Tests</h2>

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

                    {{-- Dynamic Status Badge --}}
                    <td>
                        @if($appointment->status == 'scheduled')
                            <span class="badge bg-warning text-dark">Scheduled</span>
                        @elseif($appointment->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                        @endif
                    </td>

                    {{-- Dynamic Visit Badge --}}
                    <td>
                        @if($appointment->visit_status == 'pending')
                            <span class="badge bg-secondary">Pending</span>
                        @elseif($appointment->visit_status == 'used')
                            <span class="badge bg-success">Used</span>
                        @else
                            <span class="badge bg-light text-dark">{{ ucfirst($appointment->visit_status ?? 'N/A') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>
@endsection
