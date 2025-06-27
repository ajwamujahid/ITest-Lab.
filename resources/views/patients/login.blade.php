@extends('layouts.patient-app')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container  d-flex justify-content-center align-items-center py-5">
    <div class="col-md-6 col-lg-5">
        <div class="card  border-0">
            <div class=" mt-4 text-center text-black ">
                <h4 class="mb-0 py-2 text-primary">Patient Login</h4>
                <p>Access your patient dashboard securely </p>
            </div>

            <div class="card-body px-4 py-4">
                {{-- Validation & Session Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Form Start --}}
                <form method="POST" action="{{ route('patient.login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fs-14 text-dark">Email Address</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-mail-line"></i></div>
                            <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fs-14 text-dark">Enter Name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-user-line"></i></div>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your name" value="{{ old('name') }}" required>
                        </div>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fs-14 text-dark">Enter Password</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-lock-line"></i></div>
                            <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                        </div>
                    </div>

                    {{-- Policy Checkbox --}}
                    {{-- <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="policyCheck" required>
                        <label class="form-check-label" for="policyCheck">
                            Accept Privacy Policy
                        </label>
                    </div> --}}

                    {{-- Submit --}}
                    <div class="text-center  mb-3">
                        <button type="submit" class="btn btn-primary">
                             <i class="ri-login-circle-line me-1"></i>Login</button>
                    </div>

                    {{-- Sign up link --}}
                    <div class="text-center">
                        <small class="text-muted">
                            Don't have an account? 
                            <a href="{{ route('patient.register.form') }}" class="text-decoration-none">Sign Up</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
