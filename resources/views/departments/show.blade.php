@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Department Details</h1>

    <p><strong>Name:</strong> {{ $department->name }}</p>
    <p><strong>Manager:</strong> {{ $department->manager ? $department->manager->name : 'Not assigned' }}</p>
    <p><strong>Description:</strong> {{ $department->description }}</p>

    <h3>Employees in this Department</h3>
    <ul>
        @forelse ($department->employees as $employee)
            <li>{{ $employee->name }}</li>
        @empty
            <li>No employees assigned to this department yet.</li>
        @endforelse
    </ul>

    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to Departments</a>
</div>
@endsection
