@extends('layouts.auth-layout')

@extends('layouts.auth-layout')

@section('title', 'Rider Login')
@section('content')
<div class="container mt-2">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-5">
                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <h4 class="mb-0 py-2 text-primary">Rider Login</h4>
                        <p class="text-muted mb-0">Enter your credentials to access rider panel</p>
                    </div>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('rider.login.submit') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label text-dark">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="rider@example.com" required autofocus>
                            </div>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label text-dark">Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-user-line"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Rider Name" required>
                            </div>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="form-label text-dark">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-lock-line"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-login-circle-line me-1"></i>  Login
                            </button>
                        </div>

                        {{-- Optional link --}}
                        <div class="text-center">
                            <small class="text-muted">Need help? <a href="#">Contact Support</a></small>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
