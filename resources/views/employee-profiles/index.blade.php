@extends('layouts.master')

@section('content')
<div class="container">
    <h4>Employee Profiles</h4>

    {{-- Filters --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="branch_id" class="form-control">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="role" class="form-control">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by name/email" value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Branch</th>
                    <th>Join Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_type }}</td>
                        <td>{{ $user->branch->name ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm btn-info view-profile"
                                    data-id="{{ $user->id }}"
                                    data-type="{{ $user->user_type }}">
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No employees found.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $employees->withQueryString()->links() }}
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Employee Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="profileContent">
        Loading...
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.view-profile').on('click', function () {
        let id = $(this).data('id');
        let type = $(this).data('type');

        $.get(`/employee-profiles/${id}?type=${type}`, function (data) {
            let html = `
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Email:</strong> ${data.email ?? 'N/A'}</p>
                <p><strong>Role:</strong> ${type}</p>
                <p><strong>Branch:</strong> ${data.branch?.name ?? 'N/A'}</p>
                <p><strong>CNIC:</strong> ${data.cnic ?? 'N/A'}</p>
                <p><strong>Phone:</strong> ${data.phone ?? 'N/A'}</p>
                <p><strong>Qualifications:</strong> ${data.qualifications ?? 'N/A'}</p>
                <p><strong>Address:</strong> ${data.address ?? 'N/A'}</p>
                <p><strong>Join Date:</strong> ${data.created_at}</p>
            `;
            $('#profileContent').html(html);
            $('#profileModal').modal('show');
        });
    });
});
</script>
@endpush
