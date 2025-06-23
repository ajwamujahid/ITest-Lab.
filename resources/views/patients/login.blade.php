@extends('layouts.patient-app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header text-center bg-primary text-white rounded-top">
                <h4 class="mb-0 py-2">Patient Login</h4>
            </div>

            <div class="card-body px-4 py-4">
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
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('patient.login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                    <div class="text-center">
                        <small class="text-muted">
                            Don't have an account? 
                            <a href="{{ route('patient.register.form') }}" class="text-decoration-none">Sign Up</a>
                        </small>
                    </div>
                </form>
            </div>

            <div class="card-footer text-center text-muted small">
                &copy; {{ date('Y') }} Patient Panel
            </div>
        </div>
    </div>
</div>
@endsection
