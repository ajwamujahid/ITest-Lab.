@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Create Role & Add Permission</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('roles.storeWithPermission') }}">
        @csrf

        <!-- Role Name & New Permission in one row -->
        <div class="row">
            <!-- Role Name -->
            <div class="col-md-6 mb-3">
                <label for="role_name" class="form-label">Role Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="role_name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    required 
                    value="{{ old('name') }}"
                >
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Add New Permission -->
            <div class="col-md-6 mb-3">
                <label for="new_permission" class="form-label">Add New Permission (optional)</label>
                <input 
                    type="text" 
                    name="new_permission" 
                    id="new_permission" 
                    class="form-control @error('new_permission') is-invalid @enderror" 
                    value="{{ old('new_permission') }}"
                    placeholder="Enter new permission name"
                >
                @error('new_permission')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Permissions Section -->
        <div class="mb-3">
            <label class="form-label">Assign Existing Permissions</label>
            <div class="border p-2 rounded" style="max-height: 200px; overflow-y: auto;">
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->id }}" 
                            id="perm{{ $permission->id }}"
                            {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('permissions')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Role & Permission</button>
    </form>
</div>
@endsection
