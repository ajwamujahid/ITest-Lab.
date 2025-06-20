@extends('layouts.patient-master')
@section('title', 'Step 1: Patient Info')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Step 1: Enter Your Information</h2>
    <form action="{{ route('test.step1.post') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Name, Email, etc -->
            <div class="col-md-4 mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-2 mb-3">
                <label>Age</label>
                <input type="number" name="age" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
        </div>
        <button class="btn btn-primary">Next</button>
    </form>
</div>
@endsection
