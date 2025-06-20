@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Role</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div>
                @foreach($permissions as $permission)
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="permissions[]"
                        value="{{ $permission->id }}"
                        id="perm{{ $permission->id }}"
                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                    <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
