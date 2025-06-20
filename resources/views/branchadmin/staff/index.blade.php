@extends('layouts.branch-master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Branch Staff</h2>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($staff as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ ucfirst($member->role) ?? 'N/A' }}</td>
                    <td>{{ $member->department_name }}</td>
                    <td>
                        @if ($member->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                    
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No staff found for this branch.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
