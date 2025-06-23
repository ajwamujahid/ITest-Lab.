@extends('layouts.patient-master')

@section('title', 'Lodge Complaint')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <div class="card complaint-form-wrapper shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center text-primary mb-4">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Lodge a Complaint
                    </h2>

                    @if(session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="patient_name" class="form-label">Your Name</label>
                                <input type="text" name="patient_name" id="patient_name"
                                       class="form-control @error('patient_name') is-invalid @enderror"
                                       value="{{ old('patient_name') }}" required>
                                @error('patient_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="target_role" class="form-label"> Complain To</label>
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

                            <div class="col-md-6">
                                <label for="branch" class="form-label">Branch</label>
                                <select name="branch" id="branch"
                                        class="form-select @error('branch') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('branch') ? '' : 'selected' }}>Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="attachment" class="form-label">Attachment (optional)</label>
                                <input type="file" name="attachment" id="attachment"
                                       class="form-control @error('attachment') is-invalid @enderror">
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="complaint_text" class="form-label"> Your Complaint</label>
                                <textarea name="complaint_text" id="complaint_text" rows="4"
                                          class="form-control @error('complaint_text') is-invalid @enderror"
                                          placeholder="Write your complaint in detail..." required>{{ old('complaint_text') }}</textarea>
                                @error('complaint_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-send"></i> Submit Complaint
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .complaint-form-wrapper {
        background-color: #fdfdfd;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    h2 {
        font-weight: 700;
        color: #0d6efd;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 8px !important;
    }

    .btn-primary {
        font-weight: 600;
        font-size: 1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .invalid-feedback {
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .complaint-form-wrapper {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush
