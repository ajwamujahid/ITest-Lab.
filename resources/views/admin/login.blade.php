@extends('layouts.auth-layout')

@section('title', 'Admin Login')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-5">
                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <h4 class="mb-0 py-2 text-primary">Admin Login</h4>
                        <p class="text-muted mb-0">Enter your credentials to access admin panel</p>
                    </div>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label text-dark">Email Address</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-mail-line"></i></div>
                                <input type="email" name="email" class="form-control" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="form-label text-dark">Password</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-lock-line"></i></div>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-login-circle-line me-1"></i>  Login
                            </button>
                        </div>

                        {{-- Forgot Link (optional) --}}
                        <div class="text-center">
                            <small class="text-muted">
                                Forgot password? <a href="#">Reset here</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
