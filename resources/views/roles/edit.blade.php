@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header  rounded-top-4">
                    <h4 class="mb-0">
                        <i class="bx bx-edit-alt me-2"></i> Edit Role
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Role Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Role Name</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $role->name) }}"
                                placeholder="Enter role name"
                                required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Permissions --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input"
                                                name="permissions[]"
                                                id="perm{{ $permission->id }}"
                                                value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm{{ $permission->id }}">
                                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                              Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                              Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
