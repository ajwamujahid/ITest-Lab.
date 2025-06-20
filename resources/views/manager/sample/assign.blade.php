@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">🧪 Assign Sample Collection</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('sample.assign.store') }}">
        @csrf

        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                <option value="">Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="rider_id" class="form-label">Assign to Rider</label>
            <select name="rider_id" class="form-select" required>
                <option value="">Select Rider</option>
                @foreach($riders as $rider)
                    <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Test Type</label>
            <input type="text" name="test_type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Assign Sample</button>
    </form>
</div>
@endsection
