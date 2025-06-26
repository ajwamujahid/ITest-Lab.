@extends('layouts.patient-app') 

@section('title', 'Patient Registration')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-icon-wrapper {
    position: relative;
}

.select2-custom-icon {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 39px;
    background-color: #e9ecef; /* Bootstrap's default input-group-text background */
    color: #6c757d; /* Text-muted color */
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ced4da;
    border-right: none;
    border-radius: 0.375rem 0 0 0.375rem;
    z-index: 10;
    pointer-events: none;
}


    .select2-container--default .select2-selection--single {
        padding-left: 2.2rem !important;
        height: 38px !important;
        border-radius: 0.375rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 15 !important;
    }
    .select2-container .select2-selection--single {
    height: 38px !important;
}

.select2-selection__rendered {
    line-height: 38px !important;
}


</style>


@endpush

@php
    use App\Models\Branch;
    $branches = Branch::all();
@endphp

<div class="container my-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <h4 class="mb-0 py-2 text-primary">Patient Registration</h4>
                        <p class="text-muted mb-0">Please fill in the form to create your account</p>
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

                    {{-- Form --}}
                    <form method="POST" action="{{ route('patient.register') }}">
                        @csrf

                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-user-line"></i></div>
                                    <input type="text" name="name" class="form-control" placeholder="Your name" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-mail-line"></i></div>
                                    <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-phone-line"></i></div>
                                    <input type="text" name="phone" class="form-control" placeholder="+92XXXXXXXXXX" value="{{ old('phone') }}">
                                </div>
                            </div>

                            {{-- DOB --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Date of Birth</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-calendar-line"></i></div>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="col-12 mb-3">
                                <label class="form-label fs-14 text-dark">Address</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-map-pin-line"></i></div>
                                    <input type="text" name="address" class="form-control" placeholder="Street, City" value="{{ old('address') }}">
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Gender</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-user-2-line"></i></div>
                                    <select name="gender" class="form-select" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Select Branch</label>
                                <div class="select2-icon-wrapper position-relative">
                                    <i class="ri-building-line select2-custom-icon"></i>
                                    <select name="branch_id" class="form-select select2 ps-5" required>
                                        <option value="">Choose Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            

                            {{-- Password --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fs-14 text-dark">Password</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-lock-line"></i></div>
                                    <input type="password" name="password" class="form-control" placeholder="********" required>
                                </div>
                                {{-- <small class="text-muted">Minimum 8 characters</small> --}}
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fs-14 text-dark">Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ri-lock-password-line"></i></div>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="********" required>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class=" text-center mb-3">
                            <button type="submit" class="btn btn-primary ">
                              Create Account
                            </button>
                        </div>

                        {{-- Login link --}}
                        <div class="text-center">
                            <small class="text-muted">Already have an account?
                            <a href="{{ route('patient.login.form') }}" class="">Login here</a>
                        </small>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.select2').select2({
    placeholder: "Choose Branch",
    allowClear: true,
    width: '100%',
    // margin-left: '20px',

});

    });
</script>
@endpush