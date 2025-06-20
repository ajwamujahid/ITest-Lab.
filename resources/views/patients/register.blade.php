@extends('layouts.patient-app') {{-- Use this for auth-specific layout --}}

@section('title', 'Patient Registration')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">👤 Patient Signup</h3>
                        <p class="text-muted mb-0">Please fill in the form to create an account</p>
                    </div>

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

                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg" required placeholder="John Doe">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg" required placeholder="you@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control form-control-lg" placeholder="+123456789">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control form-control-lg">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select form-select-lg">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-lg" required placeholder="********">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" required placeholder="********">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                        </div>

                        <div class="text-center mt-3">
                            Already registered? <a href="{{ route('patient.login.form') }}" class="text-decoration-none">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4 text-muted">
                &copy; {{ date('Y') }} Patient Portal. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection
