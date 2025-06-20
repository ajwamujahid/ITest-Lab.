@extends('layouts.branch-master')
@section('content')
<div class="container">
    <h2>Rider Report: {{ $rider->name }}</h2>
    <p><strong>Phone:</strong> {{ $rider->phone }}</p>
    <p><strong>Vehicle:</strong> {{ $rider->vehicle_type }} ({{ $rider->vehicle_number }})</p>

    <hr>

    <h4>🗂️ Assigned Appointments</h4>
    @if($appointments->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $a)
                    <tr>
                        <td>{{ $a->patient_name }}</td>
                        <td>{{ $a->appointment_date }}</td>
                        <td>{{ $a->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No appointments found for this rider.</p>
    @endif

    <hr>

    <h4>🌟 Rider Reviews</h4>
    @if($reviews->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->patient_name }}</td>
                        <td>{{ $review->rating }} / 5</td>
                        <td>{{ $review->comments }}</td>
                        <td>{{ $review->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No reviews yet for this rider.</p>
    @endif

</div>
@endsection
