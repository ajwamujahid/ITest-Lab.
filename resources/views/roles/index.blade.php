@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bx bx-shield-alt-2 me-2"></i> Manage Roles
        </h4>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Add New Role
        </a>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- 📋 Roles Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th class="text-start px-4">Role Name</th>
                        <th>Permissions</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="text-start">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 align-middle">
                                <strong>{{ ucfirst($role->name) }}</strong>
                            </td>
                            <td class="align-middle">
                                @forelse($role->permissions as $perm)
                                    <span class="text-dark me-1 mb-1">
                                        {{ str_replace(['-', '_'], ' ', $perm->name) }}
                                    </span>
                                @empty
                                    <span class="text-muted">No Permissions</span>
                                @endforelse
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bx bx-edit-alt"></i> 
                                </a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i> 
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                No roles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
