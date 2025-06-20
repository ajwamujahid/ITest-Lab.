@extends('layouts.rider-master')

@section('content')
<div class="container py-4">
    <h3 class="text-primary fw-bold mb-4"><i class="bx bx-message-dots"></i> Patient Reviews</h3>

    @forelse($reviews as $review)
        <div class="card mb-3 shadow-sm border rounded">
            <div class="card-body">
                <h5 class="mb-1">{{ $review->patient->name ?? 'Unknown Patient' }}</h5>


                <p class="mb-1">
                    <strong>Rating:</strong> 
                    @for ($i = 0; $i < $review->rating; $i++)
                        ⭐
                    @endfor
                </p>
                <p class="mb-1"><strong>Message:</strong> {{ $review->message }}</p>
                <small class="text-muted">Reviewed on {{ $review->created_at->format('d M Y, h:i A') }}</small>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No reviews yet from patients.</div>
    @endforelse
</div>
@endsection
