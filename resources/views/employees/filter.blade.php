@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Branch Managers</h3>
    <a href="{{ route('branch-admin.create') }}" class="btn btn-primary mb-3"> Add New Manager</a>

    {{-- Filters --}}
    {{-- <form action="{{ route('employees.filter') }}" method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label for="role_id" class="form-label fw-semibold">Role</label>
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="support_agent" {{ request('role') == 'support_agent' ? 'selected' : '' }}>Support Agent</option>
                <option value="chat_manager" {{ request('role') == 'chat_manager' ? 'selected' : '' }}>Chat Manager</option>
                <option value="collection_manager" {{ request('role') == 'collection_manager' ? 'selected' : '' }}>Collection Manager</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="branch_id" class="form-label fw-semibold">Branch</label>
            <select name="branch_id" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </form> --}}

    {{-- Card Box --}}
    <div class="card p-4">
        @if($employees->isEmpty())
            <div class="alert alert-info">No Branch Managers found.</div>
        @else
            <table class="table table-bordered  align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Branch</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $index => $emp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $emp->name }}</td>
                        <td>{{ $emp->email ?? 'N/A' }}</td>
                        <td>{{ ucfirst($emp->role) }}</td>
                        <td>{{ $emp->branch->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $emp->status === 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($emp->status ?? 'Not Set') }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('managers.toggleStatus', $emp->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-{{ $emp->status === 'active' ? 'danger' : 'success' }}">
                                    {{ $emp->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
