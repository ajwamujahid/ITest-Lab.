@extends('layouts.branch-master')

@section('content')
<div class="container py-4">

    {{-- 🔹 Rider Profile --}}
    <div class="card mb-4 shadow-sm rounded-4">
        <div class="card-body">
            <h3 class="text-primary fw-bold mb-3">
                <i class="bi bi-person-badge-fill me-2"></i>Rider Report: {{ $rider->name }}
            </h3>
            <p><strong><i class="bi bi-telephone-fill me-1"></i>Phone:</strong> {{ $rider->phone }}</p>
            <p><strong><i class="bi bi-truck me-1"></i>Vehicle:</strong> {{ $rider->vehicle_type }} ({{ $rider->vehicle_number }})</p>
        </div>
    </div>

    {{-- 🔄 Tabs for Appointments and Reviews --}}
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="riderTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab">
                        <i class="bi bi-calendar-check me-1"></i>Appointments
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        <i class="bi bi-star-fill me-1 text-warning"></i>Reviews
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="riderTabsContent">
                {{-- Appointments Tab --}}
                <div class="tab-pane fade show active" id="appointments" role="tabpanel">
                    @if($appointments->count())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Appointment Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $a)
                                        <tr>
                                            <td>{{ $a->patient->name ?? 'N/A' }}</td>

                                            <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('d M, Y') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($a->status == 'pending') bg-warning
                                                    @elseif($a->status == 'completed') bg-success
                                                    @elseif($a->status == 'cancelled') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst($a->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No appointments found for this rider.</p>
                    @endif
                </div>

                {{-- Reviews Tab --}}
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    @if($reviews->count())
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead class="table-light">
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
                                            <td>
                                                <span class="text-warning fw-bold">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                    @endfor
                                                    ({{ $review->rating }}/5)
                                                </span>
                                            </td>
                                            <td>{{ $review->comments }}</td>
                                            <td>{{ $review->created_at->format('d M, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No reviews yet for this rider.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
