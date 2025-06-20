@extends('layouts.patient-master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">⭐ Rate Your Rider</h3>

    {{-- Rider Info --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5>👤 Rider: {{ $rider->name }}</h5>
            <p><strong>Phone:</strong> {{ $rider->phone }}</p>
            <p><strong>Vehicle:</strong> {{ $rider->vehicle_type }} - {{ $rider->vehicle_number }}</p>
        </div>
    </div>

    {{-- Review Form --}}
    <form action="{{ route('patient.reviews.store') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf

        <input type="hidden" name="rider_id" value="{{ $rider->id }}">

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1 - 5)</label>
            <select name="rating" id="rating" class="form-select" required>
                <option value="">Select rating</option>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Feedback (optional)</label>
            <textarea name="message" id="message" rows="4" class="form-control" placeholder="Write a message..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Review</button>
    </form>

    {{-- Previous Reviews --}}
    @if($previousReviews->isNotEmpty())
        <div class="mt-5">
            <h4 class="mb-3">📝 Your Previous Reviews</h4>
            @foreach($previousReviews as $review)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>⭐ Rating: {{ $review->rating }}/5</strong>
                            <small class="text-muted">{{ $review->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                        @if($review->message)
                            <p class="mt-2">{{ $review->message }}</p>
                        @else
                            <p class="text-muted fst-italic mt-2">No message given.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
