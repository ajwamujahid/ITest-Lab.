@extends('layouts.patient-master')

@section('title', 'Lodge Complaint')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        {{-- Sidebar assumed to be on left, taking 3 columns --}}
        <div class="col-md-1">
            {{-- You can leave this empty or use @include for your sidebar --}}
        </div>

        {{-- Main content area --}}
        <div class="col-md-9">
            <div class="complaint-form-wrapper card custom-card shadow-sm p-4">
                <h2 class="mb-4 text-center">Lodge Complaint</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="patient_name" class="form-label">Your Name</label>
                            <input type="text" name="patient_name" id="patient_name"
                                class="form-control @error('patient_name') is-invalid @enderror"
                                value="{{ old('patient_name') }}" required>
                            @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="target_role" class="form-label">Complain To</label>
                            <select name="target_role" id="target_role"
                                class="form-select @error('target_role') is-invalid @enderror" required>
                                <option value="" disabled {{ old('target_role') ? '' : 'selected' }}>Select Role</option>
                                <option value="super_admin" {{ old('target_role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ old('target_role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('target_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="branch" class="form-label">Branch</label>
                            <select name="branch" id="branch"
                                class="form-select @error('branch') is-invalid @enderror" required>
                                <option value="" disabled {{ old('branch') ? '' : 'selected' }}>Select Branch</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option> <!-- not what you want -->
                            @endforeach
                            
                            </select>
                            @error('branch')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="attachment" class="form-label">Attachment (optional)</label>
                            <input type="file" name="attachment" id="attachment"
                                class="form-control @error('attachment') is-invalid @enderror">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="complaint_text" class="form-label">Complaint</label>
                        <textarea name="complaint_text" id="complaint_text" rows="4"
                                class="form-control @error('complaint_text') is-invalid @enderror" required>{{ old('complaint_text') }}</textarea>
                        @error('complaint_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Submit Complaint</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .complaint-form-wrapper {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        max-width: 100%;
    }

    h2 {
        font-weight: 700;
        color: #0d6efd;
    }

    .form-label {
        font-weight: 600;
    }

    .form-control, .form-select {
        border-radius: 6px !important;
    }

    .btn-primary {
        font-weight: 600;
        font-size: 16px;
        padding: 10px;
        border-radius: 8px;
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .col-md-3 {
            display: none; /* hide sidebar on mobile */
        }

        .col-md-9 {
            width: 100%;
        }

        .complaint-form-wrapper {
            padding: 20px;
        }
    }
</style>
@endpush
