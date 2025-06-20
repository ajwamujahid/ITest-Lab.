@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>All Riders</h2>

    <a href="{{ route('branchadmin.riders.create') }}" class="btn btn-primary mb-3">Add New Rider</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Vehicle</th>
                <th>Actions</th> <!-- For View Report -->
            </tr>
        </thead>
        <tbody>
            @foreach($riders as $rider)
                <tr>
                    <td>{{ $rider->name }}</td>
                    <td>{{ $rider->phone }}</td>
                    <td>{{ $rider->vehicle_type }} ({{ $rider->vehicle_number }})</td>
                    <td>
                        <a href="{{ route('branchadmin.riders.report', $rider->id) }}" class="btn btn-info btn-sm">
                            View Report
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
