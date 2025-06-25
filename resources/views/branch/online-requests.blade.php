@extends('layouts.branch-master')

@section('content')
<div class="container mt-5">
    <h2>Unassigned Online Appointments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ✅ First check if there are requests --}}
    @if($requests->count())
        @foreach($requests as $request)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Patient: {{ $request->patient_name }}</h5>
                <p class="card-text">
                    <strong>Test:</strong> {{ $request->test_name }}<br>
                    <strong>Requested On:</strong> {{ $request->created_at->format('d M Y') }}
                </p>

                {{-- 📝 Assign Rider Form --}}
                <form action="{{ route('branch.assign.appointment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="test_request_id" value="{{ $request->id }}">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Assign Rider:</label>
                            <select name="rider_id" class="form-select" required>
                                <option value="">-- Select Rider --</option>
                                @foreach($riders as $rider)
                                    <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Date:</label>
                            <input type="date" name="appointment_date" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label>Time:</label>
                            <input type="time" name="appointment_time" class="form-control" required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Assign</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

    @else
        {{-- ❌ Only show this if no requests at all --}}
        <div class="alert alert-info">No online appointments to assign.</div>
    @endif
</div>
@endsection
