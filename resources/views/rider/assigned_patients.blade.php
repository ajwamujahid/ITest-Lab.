@extends('layouts.rider-master')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bx bx-user-pin"></i> Assigned Patients
        </h2>
    </div>

    <div class="table-responsive rounded shadow-sm border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Test Type</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
                    <tr>
                        {{-- 📅 Date --}}
                        <td>
                            <span class="text-dark fw-semibold">
                                {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y, h:i A') }}
                            </span>
                        </td>

                        {{-- 👤 Patient Info --}}
                        <td>
                            @if($appt->testRequest && $appt->testRequest->patient)
                                <strong>{{ $appt->testRequest->patient->name }}</strong><br>
                                <small class="text-muted">{{ $appt->testRequest->patient->phone }}</small>
                            @else
                                <strong>N/A</strong><br>
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>

                        {{-- 🧪 Test Type (name) --}}
                        <td>{{ $appt->testRequest->test_name ?? 'N/A' }}</td>

                        {{-- 🏠 Address --}}
                        <td>{{ $appt->testRequest->address ?? 'N/A' }}</td>

                        {{-- 📌 Status --}}
                        <td>
                            <span class="badge text-white 
                                @if($appt->status == 'scheduled') bg-warning 
                                @elseif($appt->status == 'completed') bg-success 
                                @elseif($appt->status == 'cancelled') bg-danger 
                                @else bg-info 
                                @endif">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>

                        {{-- 📍 Location Button --}}
                        <td>
                            <a href="{{ route('rider.track.patient', $appt->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                View Map
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            🚫 No assigned patients found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>

</div>
@endsection
