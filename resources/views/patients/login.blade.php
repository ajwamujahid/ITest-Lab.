@extends('layouts.patient-app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 420px; width: 100%;">
        <h2 class="text-center mb-4 fw-bold text-primary">👤 Patient Login</h2>

        {{-- Show Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('patient.login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="you@example.com" value="{{ old('email') }}" required autofocus />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="********" required />
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>

            <div class="text-center">
                <small class="text-muted">Don't have an account? <a href="{{ route('patient.register.form') }}" class="text-decoration-none">Sign Up</a></small>
            </div>
        </form>
    </div>
</div>
@endsection
