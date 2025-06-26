@extends('layouts.master')

@section('title', 'Departments')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">
        <i class="bx bx-network-chart"></i> Departments
    </h3>
    
        <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">
             Add New Department
        </a>
   

    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">

                  
                    {{-- Success Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered  align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Manager</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departments as $dept)
                                    <tr>
                                        <td class="text-start">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-start">{{ $dept->name }}</td>
                                        <td>
                                            @if($dept->manager)
                                                <span class=" text-start">{{ $dept->manager->name }}</span>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td class="text-start">{{ $dept->description ?? '—' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('departments.show', $dept->id) }}" class="btn btn-sm btn-outline-info">   <i class="bi bi-eye-fill"></i></a>
                                                <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-sm btn-outline-warning"> <i class="bi bi-pencil-fill"></i></a>
                                                <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"> <i class="bi bi-trash-fill"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No departments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($departments->hasPages())
                        <div class="mt-3">
                            {{ $departments->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
