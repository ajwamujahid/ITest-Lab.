@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-0">
        <i class="bx bx-shield-alt-2 me-2"></i> Manage Roles
    </h4>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mt-2">
        Add New Role
    </a>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mt-3">
            <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- 📋 Roles Table --}}
    <div class="card mt-4 shadow rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th class="text-start">Role Name</th>
                            <th>Permissions</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                   {{ ucfirst($role->name) }}
                                </td>
                                <td>
                                    @forelse($role->permissions as $permission)
                                        <span class=" me-1">{{ $permission->name }}</span>
                                    @empty
                                        <span class="text-muted">No permissions</span>
                                    @endforelse
                                </td>
                                
                                <td class="text-center">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>

                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block delete-role-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger confirm-delete-btn">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No roles found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.confirm-delete-btn');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const form = btn.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This role will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
