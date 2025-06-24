@extends('layouts.patient-master')
@section('title', 'Step 1: Patient Info')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 text-primary">Step 1: Enter Your Information</h2>
                    <form action="{{ route('test.step1.post') }}" method="POST">
                        @csrf
                        <div class="row g-3">

                            <!-- Full Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter your phone no" required>
                            </div>

                            <!-- Age -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Age</label>
                                <input type="number" name="age" class="form-control" min="1" max="120" placeholder="Enter your age" required>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Enter your address..." required></textarea>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button class="btn btn-primary px-4">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('patientForm');

    form.addEventListener('submit', function (e) {
        let isValid = true;
        let errorMessage = '';

        const fields = {
            name: form.querySelector('[name="name"]'),
            email: form.querySelector('[name="email"]'),
            phone: form.querySelector('[name="phone"]'),
            age: form.querySelector('[name="age"]'),
            gender: form.querySelector('[name="gender"]'),
            address: form.querySelector('[name="address"]'),
        };

        // Clear previous errors
        for (let field in fields) {
            fields[field].classList.remove('is-invalid');
        }

        // Validate each field
        for (let key in fields) {
            if (!fields[key].value.trim()) {
                fields[key].classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Please fill in all required fields.';
            }
        }

        // Age must be between 1 and 120
        const ageValue = parseInt(fields.age.value);
        if (isNaN(ageValue) || ageValue < 1 || ageValue > 120) {
            fields.age.classList.add('is-invalid');
            errorMessage = 'Age must be between 1 and 120.';
            isValid = false;
        }

        // Email format check
        const emailPattern = /^[^@]+@[^@]+\.[^@]+$/;
        if (!emailPattern.test(fields.email.value)) {
            fields.email.classList.add('is-invalid');
            errorMessage = 'Please enter a valid email.';
            isValid = false;
        }

        // Stop submission if invalid
        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
        }
    });
});
</script>
@endpush
