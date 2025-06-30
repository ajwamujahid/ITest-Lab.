@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bx bx-lock-alt me-2"></i> Create Role & Assign Permissions
                    </h5>
                </div>

                <div class="card-body">
                    {{-- ✅ Success Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    {{-- 📝 Role & Permission Form --}}
                    <form method="POST" action="{{ route('roles.storeWithPermission') }}">
                        @csrf

                        <div class="row mb-4">
                            {{-- 🏷️ Role Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="role_name" class="form-label fw-semibold">Role Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="role_name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}" 
                                    required 
                                    placeholder="e.g. Chat Manager"
                                >
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- ➕ New Permission --}}
                            <div class="col-md-6 mb-3">
                                <label for="new_permission" class="form-label fw-semibold">Add New Permission</label>
                                <input 
                                    type="text" 
                                    name="new_permission" 
                                    id="new_permission" 
                                    class="form-control @error('new_permission') is-invalid @enderror" 
                                    value="{{ old('new_permission') }}"
                                    placeholder="e.g. assign-chat-patient"
                                >
                                @error('new_permission')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- 📋 Existing Permissions --}}
                        <div class="mb-4">
                            <label for="permissions" class="form-label fw-semibold">Assign Existing Permissions</label>
                            <select name="permissions[]" id="permissions" class="form-select select2" multiple>
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission }}" 
                                        {{ (is_array(old('permissions')) && in_array($permission, old('permissions'))) ? 'selected' : '' }}>
                                        {{ ucwords(str_replace(['-', '_'], ' ', $permission)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permissions')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- 🚀 Buttons --}}
                        <div class="text-end">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">
                                <i class="bx bx-arrow-back"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Create Role
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- ✅ Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#permissions').select2({
            placeholder: "Select permissions",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection
