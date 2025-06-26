@extends('layouts.patient-master')

@section('content')
<div class="container mt-5">

    <h3 class="mb-4 text-primary">
        <i class="bx bx-star"></i> 
        Rate Your Rider</h3>

    {{-- 👤 Rider Info --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h5 class="mb-1"><i class="bx bx-user"></i> {{ $rider->name }}</h5>
                <p class="mb-1 text-muted"><i class="bx bx-phone"></i> {{ $rider->phone }}</p>
                <p class="mb-0 text-muted"><i class="bx bx-car"></i> {{ $rider->vehicle_type }} - {{ $rider->vehicle_number }}</p>
            </div>
            <img src="{{ asset($rider->photo ?? 'default-rider.png') }}" class="rounded-circle shadow" style="width: 70px; height: 70px;" alt="Rider Photo">
        </div>
    </div>

    {{-- 📝 Review Form --}}
    <form action="{{ route('patient.reviews.store') }}" method="POST" class="p-4 bg-white border rounded-4 shadow-sm">
        @csrf
        <input type="hidden" name="rider_id" value="{{ $rider->id }}">

        <div class="mb-3">
            <label for="rating" class="form-label fw-semibold">Rating</label>
            <select name="rating" id="rating" class="form-select form-select-lg" required>
                <option value="">Choose a rating</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} ({{ $i }})</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Feedback <small class="text-muted">(Optional)</small></label>
            <textarea name="message" id="message" class="form-control rounded-3" rows="4" placeholder="Write your thoughts about the rider..."></textarea>
        </div>

        <button type="submit" class="btn btn-success px-4">
            <i class="bx bx-send"></i> Submit Review
        </button>
    </form>

    {{-- 📜 Previous Reviews --}}
    @if($previousReviews->isNotEmpty())
        <div class="mt-5">
            <h4 class="mb-3 text-secondary fw-bold">Your Previous Reviews</h4>
            @foreach($previousReviews as $review)
                <div class="card mb-3 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-warning">{{ str_repeat('⭐', $review->rating) }}</span>
                            <small class="text-muted">{{ $review->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                        <div class="mt-2">
                            @if($review->message)
                                <p class="mb-0">{{ $review->message }}</p>
                            @else
                                <p class="text-muted fst-italic mb-0">No feedback given.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
