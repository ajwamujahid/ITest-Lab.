@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Appointments Report</h2>

    <form method="GET">
        <label>From:</label>
        <input type="date" name="from" value="{{ \Carbon\Carbon::parse($from)->toDateString() }}">
        <label>To:</label>
        <input type="date" name="to" value="{{ \Carbon\Carbon::parse($to)->toDateString() }}">
        <button type="submit">Filter</button>
    </form>

    <table class="table mt-4">
        <thead>
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
                    <td>{{ $appointment->patient_id }}</td>
                    <td>{{ $appointment->test_type }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
