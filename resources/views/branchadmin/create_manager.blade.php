@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <form action="{{ route('managers.store') }}" method="POST" enctype="multipart/form-data" ...>

    @csrf

        <h2 class="mb-4">Add New Manager</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">Name <span class="text-danger">*</span></label>
                <input name="name" class="form-control" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">Email <span class="text-danger">*</span></label>
                <input name="email" type="email" class="form-control" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">Phone <span class="text-danger">*</span></label>
                <input name="phone" class="form-control" required>
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">Qualification</label>
                <input name="qualification" class="form-control">
                @error('qualification') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- 🔐 Password -->
        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Password <span class="text-danger">*</span></label>
            <input name="password" type="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 🔐 Confirm Password -->
        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Confirm Password <span class="text-danger">*</span></label>
            <input name="password_confirmation" type="password" class="form-control" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">CNIC <span class="text-danger">*</span></label>
                <input name="cnic" class="form-control" required>
                @error('cnic') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">Branch <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-control" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('branch_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- 📅 DOB -->
        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Date of Birth <span class="text-danger">*</span></label>
            <input name="dob" type="date" class="form-control" required>
            @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-14 text-dark">University Name</label>
                <input name="university" class="form-control" placeholder="e.g. University of Lahore">
                @error('university') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Joining Date <span class="text-danger">*</span></label>
            <input name="joining_date" type="date" class="form-control" required>
            @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 📷 Photo -->
        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Profile Picture</label>
            <input name="photo" type="file" accept="image/*" class="form-control">
            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fs-14 text-dark">Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="e.g. House #123, Street 4, Lahore"></textarea>
            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2">Add Manager</button>
    </form>
</div>
@endsection
