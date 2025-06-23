@extends('layouts.patient-master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3"> Scheduled Appointments</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Test Type</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>

                    {{-- Test Type --}}
                    <td>
                        @if($appointment->test_type == 'physical')
                        <span class="badge bg-primary"> Physical Test</span>
                    @else
                        <span class="badge bg-warning text-dark"> Sample Test</span>
                    @endif
                    
                    </td>

                    <td>{{ $appointment->appointment_date }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($appointment->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}" 
                              onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            @csrf
                            <button class="btn btn-sm btn-danger">Cancel</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No scheduled appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
