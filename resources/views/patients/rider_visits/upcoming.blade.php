@extends('layouts.patient-master')

@section('content')
<div class="container">
    <h2>Upcoming Rider Visits</h2>

    @if($upcomingAppointments->isEmpty())
        <p>No upcoming appointments found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Appointment Date</th>
                    <th>Rider Name</th>
                    <th>Rider Phone</th>
                    <th>Vehicle Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($upcomingAppointments as $appointment)
                    <tr>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->rider_id }} - {{ $appointment->rider ? $appointment->rider->name : 'Not Found' }}</td>
                        <td>{{ optional($appointment->rider)->phone ?? '-' }}</td>
                        <td>
                            {{ optional($appointment->rider)->vehicle_type ?? '' }} -
                            {{ optional($appointment->rider)->vehicle_number ?? '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
