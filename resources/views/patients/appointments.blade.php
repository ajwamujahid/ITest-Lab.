@extends('layouts.patient-master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📋 My Scheduled Appointments</h3>

    @if($appointments->isEmpty())
        <p>No appointments found.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Test Name(s)</th>
                        <th>Amount</th>
                        <th>Payment Method</th> {{-- ✅ NEW COLUMN --}}
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Rider Info</th>
                        <th>Photo</th>
                        <th>Pickup From</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>

                            {{-- ✅ Convert comma-separated test_type into test names --}}
                            <td>
                                @php
                                    $testIds = explode(',', $appointment->test_type);
                                @endphp
                                @foreach ($testIds as $testId)
                                    {{ $tests->get((int)$testId)->name ?? 'Unknown Test' }}<br>
                                @endforeach
                            </td>

                            <td>Rs. {{ number_format($appointment->amount, 2) }}</td>
                            {{-- <td>{{ ucfirst($appointment->payment_method ?? 'N/A') }}</td> --}}
                            <td>
                                @if($appointment->testRequest)
                                    <span class="badge bg-success">
                                        {{ ucfirst($appointment->testRequest->payment_method) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y H:i') }}</td>
                            <td>{{ ucfirst($appointment->status ?? 'pending') }}</td>

                            {{-- ✅ Rider Info --}}
                            <td>
                                <strong>Name:</strong> {{ $appointment->rider->name ?? 'N/A' }}<br>
                                <strong>Phone:</strong> {{ $appointment->rider->phone ?? 'N/A' }}<br>
                                <strong>Vehicle:</strong> {{ $appointment->rider->vehicle_type ?? '' }} - {{ $appointment->rider->vehicle_number ?? '' }}
                            </td>

                            <td>
                                @if(optional($appointment->rider)->photo)
                                    <img src="{{ asset('storage/' . $appointment->rider->photo) }}"
                                         width="60" height="60" class="rounded-circle">
                                @else
                                    N/A
                                @endif
                            </td>
                            

                            <td>
                                <a href="{{ route('patient.track.rider', $appointment->id) }}" class="btn btn-sm btn-primary mb-1">
                                    Track Rider
                                </a>
                            
                                @if($appointment->rider_id)
                                    <a href="{{ route('patient.reviews.create', $appointment->rider_id) }}" class="btn btn-sm btn-warning">
                                        Review Rider
                                    </a>
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
