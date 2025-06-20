@extends('layouts.patient-master')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">🧪 Your Physical Test Appointments</h3>

    @if($appointments->count())
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Test</th>
                    <th>Status</th>
                    <th>Visit</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        {{-- 🗓️ Appointment Date --}}
                        <td>{{ $appointment->appointment_date->format('d M Y h:i A') }}</td>

                        {{-- 👤 Patient Name --}}
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>

                        {{-- 🧪 Test Name --}}
                        <td><strong>{{ $appointment->test_type }}</strong></td>

                        {{-- 📌 Status Badge --}}
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : 'info' }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>

                        {{-- 👣 Visit Status --}}
                        <td>
                            <span class="badge bg-{{ $appointment->visit_status === 'visited' ? 'success' : 'warning' }}">
                                {{ ucfirst($appointment->visit_status) }}
                            </span>
                        </td>

                        <td>
                            @php
                                $invoicePath = $appointment->invoice?->invoice_url;
                            @endphp
                    
                            @if($invoicePath && file_exists(public_path('storage/' . $invoicePath)))
                                <a href="{{ asset('storage/' . $invoicePath) }}"
                                   target="_blank"
                                   class="text-decoration-underline text-primary">
                                    Download Invoice
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">You have no physical test appointments yet.</div>
    @endif
</div>
@endsection
