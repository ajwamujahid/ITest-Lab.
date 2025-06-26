@extends('layouts.branch-master')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4 fw-bold text-primary">
        <i class="bx bx-group me-2"></i> Branch Staff
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔎 Staff Table --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light text-uppercase small">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Action</th> {{-- ✅ New Column --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($staff as $member)
                    <tr>
                        <td class="fw-semibold">{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ ucfirst($member->role) ?? 'N/A' }}</td>
                        <td>{{ $member->department_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge text-white px-3 py-1 
                                {{ $member->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('branch.staff.toggleStatus', $member->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $member->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                                    {{ $member->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bx bx-info-circle me-1"></i> No staff found for this branch.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
