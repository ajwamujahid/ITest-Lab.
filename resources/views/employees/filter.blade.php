@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">🔍 Filter Managers</h3>

    <form action="{{ route('employees.filter') }}" method="GET" class="row g-3 align-items-end mb-4">

        {{-- Role Filter --}}
        <div class="col-md-4">
            <label for="role_id" class="form-label fw-semibold">Role</label>
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="support_agent" {{ request('role') == 'support_agent' ? 'selected' : '' }}>Support Agent</option>
                <option value="chat_manager" {{ request('role') == 'chat_manager' ? 'selected' : '' }}>Chat Manager</option>
                <option value="collection_manager" {{ request('role') == 'collection_manager' ? 'selected' : '' }}>Collection Manager</option>
            </select>
             
        </div>

        {{-- Branch Filter --}}
        <div class="col-md-4">
            <label for="branch_id" class="form-label fw-semibold">Branch</label>
            <select name="branch_id" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
            
            </select>
            
        </div>

        {{-- Submit --}}
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">
                🔍 Apply Filters
            </button>
        </div>
    </form>

    {{-- Results --}}
    @if($employees->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Branch</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $index => $emp)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->email ?? 'N/A' }}</td>
                            <td>{{ ucfirst($emp->role) }}</td>
                            <td>{{ $emp->branch->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            ⚠️ No managers found for the selected filters.
        </div>
    @endif
</div>
@endsection
