@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Manager Reports</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Branch</label>
            <select name="branch" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
@endforeach

            </select>
        </div>


        <div class="col-md-3">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('employee.reports.export') }}" class="btn btn-success w-100">Export CSV</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Branch</th>
                <th>Department</th>
                <th>Joining Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($managers as $index => $manager)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $manager->name }}</td>
                    <td>{{ $manager->email }}</td>
                    <td>{{ ucfirst($manager->role) }}</td>
                    <td>{{ $manager->branch->name ?? 'N/A' }}</td>
                    <td>{{ $manager->department->name ?? 'N/A' }}</td>
                    <td>{{ $manager->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $managers->withQueryString()->links() }}
</div>
@endsection
