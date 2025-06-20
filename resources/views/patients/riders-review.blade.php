@extends('layouts.patient-master')

@section('content')
<h3>Rider Review Section</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@foreach($visits as $visit)
    <div class="card mb-3">
        <div class="card-body">

            @if($visit->riderReview)
                {{-- ✅ Already reviewed — show only the review --}}
                <h4 class="fw-bold text-success">👤 {{ $visit->rider->name }}</h4>
                <p><strong>Phone:</strong> {{ $visit->rider->phone }}</p>

                <h6 class="mt-2">Your Submitted Review</h6>
                <p><strong>Rating:</strong>
                    @for($i = 1; $i <= 5; $i++)
                        <span>{{ $i <= $visit->riderReview->rating ? '⭐' : '☆' }}</span>
                    @endfor
                </p>
                <p><strong>Message:</strong> {{ $visit->riderReview->message ?? 'No message left.' }}</p>

            @else
                {{-- ❌ Not reviewed — show info and review form --}}
                <h4 class="fw-bold text-primary">👤 {{ $visit->rider->name }}</h4>
                <p>Phone: {{ $visit->rider->phone }}</p>
                <p>Vehicle: {{ $visit->vehicle_info }}</p>

                @if($visit->rider_photo)
                    <img src="{{ asset('storage/riders/' . $visit->rider_photo) }}" width="80" />
                @endif

                <form method="POST" action="{{ route('riders.review.store') }}">
                    @csrf
                    <input type="hidden" name="rider_id" value="{{ $visit->rider->id }}">

                    <div class="mb-2">
                        <label>Rating:</label><br>
                        @for($i = 1; $i <= 5; $i++)
                            <label>
                                <input type="radio" name="rating" value="{{ $i }}" required>
                                ⭐
                            </label>
                        @endfor
                    </div>

                    <div class="mb-2">
                        <textarea name="message" rows="2" class="form-control" placeholder="Write your feedback..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-sm btn-success">Submit Review</button>
                </form>
            @endif

        </div>
    </div>
@endforeach
@endsection
