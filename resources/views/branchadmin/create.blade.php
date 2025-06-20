@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <form action="{{ route('branchadmin.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm" style="background-color: #fff;">
        @csrf

        <h2 class="mb-4">Add New Branch Admin</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">Name <span class="text-danger">*</span></label>
                <input name="name" class="form-control" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>

            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">Email <span class="text-danger">*</span></label>
                <input name="email" type="email" class="form-control" required>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">Phone <span class="text-danger">*</span></label>
                <input name="phone" class="form-control" required>
                @error('phone no')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>

            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">Qualification <span class="text-danger">*</span></label>
                <input name="qualification" class="form-control" required>
                @error('qualification')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">CNIC <span class="text-danger">*</span></label>
                <input name="cnic" class="form-control" required>
                @error('cnic')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>

            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">Branch <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-control" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="gender" class="form-label fs-14 text-dark">Gender <span class="text-danger">*</span></label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="form-text" class="form-label fs-14 text-dark">Age <span class="text-danger">*</span></label>
                <input name="age" type="number" min="18" max="100" class="form-control" required>
                @error('age')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="form-text" class="form-label fs-14 text-dark">University Name</label>
            <input name="university" class="form-control" placeholder="e.g. University of Lahore">
            @error('university')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label for="form-text" class="form-label fs-14 text-dark">Joining Date <span class="text-danger">*</span></label>
            <input name="joining_date" type="date" class="form-control" required>
            @error('joining_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Profile Picture</label>
            <input name="profile_picture" type="file" accept="image/*" class="form-control">
            @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label for="form-text" class="form-label fs-14 text-dark">Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="e.g. House #123, Street 4, Lahore"></textarea>
            @error('address')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2">Add Branch Admin</button>
    </form>
</div>
@endsection
