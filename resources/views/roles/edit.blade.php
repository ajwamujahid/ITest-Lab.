@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h4>Edit Role</h4>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Role Name --}}
        <div class="mb-3">
            <label>Role Name</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}">
        </div>

        {{-- Permissions --}}
        <div class="mb-3">
            <label>Permissions</label>
            <select name="permissions[]" class="form-select select2" multiple>
                @foreach($permissions as $perm)
                    <option value="{{ $perm }}" 
                        {{ in_array($perm, $rolePermissions) ? 'selected' : '' }}>
                        {{ ucwords(str_replace('-', ' ', $perm)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- New Permission --}}
        <div class="mb-3">
            <label>Add New Permission</label>
            <input type="text" name="new_permission" class="form-control">
        </div>

        <button class="btn btn-success">Update Role</button>
    </form>
</div>
@endsection
