@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold text-primary">🗓️ Assigned Physical Test Appointments</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($appointments->count())
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Test</th>
                    <th>Status</th>
                    <th>Visit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->appointment_date->format('d M Y h:i A') }}</td>
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->test_type }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($appointment->status) }}</span></td>
                        <td>
                            <span class="badge bg-{{ $appointment->visit_status == 'visited' ? 'success' : 'secondary' }}">
                                {{ ucfirst($appointment->visit_status) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('manager.update.visit') }}">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                <select name="visit_status" class="form-select form-select-sm d-inline-block w-auto">
                                    <option value="pending" {{ $appointment->visit_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="visited" {{ $appointment->visit_status == 'visited' ? 'selected' : '' }}>Visited</option>
                                </select>
                                <button type="submit" class="btn btn-link btn-sm text-primary text-decoration-underline">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">No physical test appointments found.</div>
    @endif
</div>
@endsection
