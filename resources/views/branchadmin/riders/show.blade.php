@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Rider Details</h2>
    <p><strong>Name:</strong> {{ $rider->name }}</p>
    <p><strong>Phone:</strong> {{ $rider->phone }}</p>
    <p><strong>Vehicle:</strong> {{ $rider->vehicle_type }} - {{ $rider->vehicle_number }}</p>

    <hr>

    <h4>Assigned Appointments</h4>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Status</th>
                <th>Appointment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>{{ $app->patient->name ?? 'N/A' }}</td>
                    <td>{{ $app->status }}</td>
                    <td>{{ $app->appointment_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h4>Patient Reviews</h4>
    <ul>
        @forelse ($reviews as $review)
            <li><strong>{{ $review->rating }} ⭐</strong> - {{ $review->comment }}</li>
        @empty
            <li>No reviews yet.</li>
        @endforelse
    </ul>
</div>
@endsection
