@extends('layouts.master')

@section('title', 'Department Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-primary fw-bold mb-0"> Department Details</h3>
                        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary">
                            Back to Departments
                        </a>
                    </div>

                    {{-- Department Info --}}
                    <div class="mb-4">
                        <p><strong>Name:</strong> {{ $department->name }}</p>
                        <p>
                            <strong>Manager:</strong>
                            @if($department->manager)
                                <span class="ext-start fw-semibold">{{ $department->manager->name }}</span>
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </p>
                        <p><strong>Description:</strong> {{ $department->description ?? '—' }}</p>
                    </div>

                    {{-- Employees List --}}
                    <h5 class="fw-bold text-dark mb-3"> Employees in this Department</h5>
                    @if($department->employees->count())
                        <ul class="list-group list-group-flush mb-4">
                            @foreach ($department->employees as $employee)
                                <li class="list-group-item">{{ $employee->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted fst-italic">No employees assigned to this department yet.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
