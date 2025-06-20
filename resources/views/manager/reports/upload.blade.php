@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-black fw-bold">🧾 Upload Lab Report</div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Patient Selection --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Patient</label>
                    <select class="form-select" name="patient_id" required>
                        <option value="">-- Choose Patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }} (ID: {{ $patient->id }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Test Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Test Type</label>
                    <input type="text" class="form-control" name="test_type" placeholder="e.g. CBC, Blood Sugar" required>
                </div>

                {{-- Notes --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Notes (optional)</label>
                    <textarea class="form-control" name="notes" rows="2" placeholder="Any remarks..."></textarea>
                </div>

                {{-- File Upload --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Report File (PDF/Image)</label>
                    <input type="file" class="form-control" name="report_file" required>
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-upload"></i> Upload Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
