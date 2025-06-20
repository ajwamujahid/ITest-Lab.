@extends('layouts.master')

@section('title', 'View Complaints')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered mt-5">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Complaint</th>
            <th>Branch</th>
            <th>Status</th> <!-- New column -->
            <th>Attachment</th>
            <th>Submitted At</th>
            <th>Actions</th> <!-- New column for update button -->
        </tr>
    </thead>
    <tbody>
        @foreach($complaints as $index => $complaint)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $complaint->patient_name }}</td>
                <td>{{ $complaint->complaint_text }}</td>
                <td>{{ $complaint->branch }}</td>
                <td>
                    <form method="POST" action="{{ route('complaints.updateStatus', $complaint->id) }}">
                        @csrf
                        @method('PATCH')

                        <select name="status" onchange="this.form.submit()" class="form-select">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in-progress" {{ $complaint->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>
                </td>
                <td>
                    @if($complaint->attachment)
                        <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank">View Attachment</a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $complaint->created_at->format('d M Y, h:i A') }}</td>
                <td>
                    <!-- Optionally, add a manual submit button -->
                    <!--<button type="submit" form="status-form-{{ $complaint->id }}" class="btn btn-primary btn-sm">Update</button>-->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
