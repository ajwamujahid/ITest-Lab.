@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h3 class="mb-4">🏢 Branch Managers List</h3>

        @if($branchAdmins->isEmpty())
            <div class="alert alert-info">No Branch Managers found.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Branch</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branchAdmins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td>{{ $admin->branch->name ?? 'N/A' }}</td>
                            <td>
                                @if(isset($admin->status))
                                    <span class="badge bg-{{ $admin->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($admin->status) }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">Not Set</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
