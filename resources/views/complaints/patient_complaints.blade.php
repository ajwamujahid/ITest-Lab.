@extends('layouts.patient-master')

@section('title', 'My Complaints')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">
        <i class="bi bi-exclamation-diamond-fill me-2"></i> My Complaints
      </h2>
      
    @if($complaints->isEmpty())
        <div class="alert alert-info text-center">You have no complaints.</div>
    @else
        <table class="table table-bordered ">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Complaint</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Attachment</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $index => $complaint)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $complaint->complaint_text }}</td>
                        <td>{{ $complaint->branch }}</td>
                        <td>
                            @if($complaint->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($complaint->status == 'in-progress')
                                <span class="badge bg-info text-dark">In Progress</span>
                            @elseif($complaint->status == 'resolved')
                                <span class="badge bg-success">Resolved</span>
                            @elseif($complaint->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span>{{ ucfirst($complaint->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($complaint->attachment)
                                <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank">View Attachment</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $complaint->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
