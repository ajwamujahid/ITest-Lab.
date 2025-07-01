@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h4 class="mb-4">
        <i class="bx bx-shield-plus me-1"></i> Create New Role & Assign Permissions
    </h4>

    {{-- ✅ Success Flash --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ❌ Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong><i class="bx bx-error-alt me-1"></i> Please fix the following:</strong>
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="bx bx-x-circle me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🧾 Form Starts --}}
    <form action="{{ route('roles.storeWithPermission') }}" method="POST">
        @csrf
        <div class="card shadow rounded-4 p-4">

            {{-- 🔤 1. Role Name --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Role Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Lab Manager" required>
                </div>
            </div>

            {{-- ➕ 2. Add New Permission --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Add New Permission</label>
                    <input type="text" name="new_permission" class="form-control" placeholder="View Reports, Edit Users">
                    {{-- <small class="text-muted">This will be created and assigned to the role.</small> --}}
                </div>
            </div>

            {{-- 🎯 3. Select Existing Permissions --}}
            <div class="row mb-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold">
                         Assign Existing Permissions
                    </label>
            
                    <div class="" style="max-height: 250px; overflow-y: auto;">
                        @forelse($permissions as $perm)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_{{ $loop->index }}">
                                <label class="form-check-label" for="perm_{{ $loop->index }}">
                                    {{ ucfirst($perm) }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted">No permissions available.</p>
                        @endforelse
                        </div>
                </div>
            </div>
            
            
            {{-- 🎯 Submit --}}
            <div class="d-flex">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bx bx-check-circle me-1"></i> Save Role
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to Roles
                </a>
            </div>

        </div>
    </form>
</div>
@endsection
