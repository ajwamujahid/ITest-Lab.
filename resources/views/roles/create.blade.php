@extends('layouts.master')

@section('content')
<div class="container py-5">
    <h4 class="mb-3">
        <i class="bx bx-lock-alt me-2"></i> Create Role & Assign Permissions
    </h4>
    <div class="card">
        {{-- <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bx bx-lock-alt me-2"></i> Create Role & Assign Permissions
            </h4>
        </div> --}}

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

                <div class="row g-3 mb-4">
                    {{-- 🏷️ Role Name --}}
                    <div class="col-md-6">
                        <label for="role_name" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
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
                    <div class="col-md-6">
                        <label for="new_permission" class="form-label fw-semibold">Add New Permission (optional)</label>
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
                    <label class="form-label fw-semibold">Assign Existing Permissions</label>
                    <div class=" p-3" style=" overflow-y: auto;">
                        @forelse($permissions as $permission)
                            <div class="form-check mb-2">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->id }}" 
                                    id="perm{{ $permission->id }}"
                                    {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="perm{{ $permission->id }}">
                                    {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted">No permissions found.</p>
                        @endforelse
                    </div>
                    @error('permissions')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                </div>

                {{-- 🚀 Submit Button --}}
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary px-4">
                        {{-- <i class="bx bx-plus-circle me-1"></i>  --}}
                        Create Role 
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
