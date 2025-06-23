@extends('layouts.patient-app') 

@section('title', 'Patient Registration')

@section('content')
@php
    use App\Models\Branch;
    $branches = Branch::all();
@endphp

<div class="container my-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">📝 Patient Registration</h2>
                        <p class="text-muted">Please fill in the form to create your account</p>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('patient.register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg" required placeholder="Enter your name" value="{{ old('name') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg" required placeholder="Enter your email" value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control form-control-lg" placeholder="Enter your phnoe no" value="{{ old('phone') }}">
                                <small class="text-muted">Format: +92XXXXXXXXXX</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control form-control-lg" value="{{ old('dob') }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-lg" placeholder="Enter your address" value="{{ old('address') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select form-select-lg" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Select Branch <span class="text-danger">*</span></label>
                                <select name="branch_id" class="form-select form-select-lg" required>
                                    <option value="">Choose Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-lg" required placeholder="Enter your password">
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" required placeholder="********">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus-fill me-2"></i> Create Account
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <small class="text-muted">Already have an account?</small>
                            <br>
                            <a href="{{ route('patient.login.form') }}" class="btn btn-link">Login here</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4 text-muted small">
                &copy; {{ date('Y') }} Patient Portal. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection
