@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">🏢 Branch Managers</h3>
    <a href="{{ route('branch-admin.create') }}" class="btn btn-primary mb-3">Add New Branch admin</a>

    <div class="card p-4 shadow-sm">
      
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
                        <th>Action</th>

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
                            <span class="badge bg-{{ $admin->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($admin->status ?? 'not set') }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('branchadmin.toggle', $admin->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $admin->status == 'active' ? 'danger' : 'success' }}">
                                    {{ $admin->status == 'active' ? 'Deactivate' : 'Activate' }}
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
