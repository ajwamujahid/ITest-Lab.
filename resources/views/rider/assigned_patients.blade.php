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
                    <th>Address</th> {{-- 🔄 Changed from "Branch" --}}
                    <th>Status</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
                    <tr>
                        <td>
                            <span class="text-dark fw-semibold">
                                {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y, h:i A') }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ optional($appt->testRequest->patient)->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ optional($appt->testRequest->patient)->phone }}</small>
                        </td>
                        <td>{{ $appt->test_type ?? 'N/A' }}</td>

                        {{-- 🏠 Address from test_requests --}}
                        <td>
                            {{ $appt->testRequest->address ?? 'N/A' }}
                        </td>

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

    <!-- Pagination -->
    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>

</div>
@endsection
