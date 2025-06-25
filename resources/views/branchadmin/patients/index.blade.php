@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h3>Patient Appointment</h3>

    {{-- ✅ Filter --}}
    <form method="GET" class="mb-4">
        <label class="me-2 fw-bold">Filter by Status:</label>
        <select name="status" onchange="this.form.submit()" class="form-select w-auto d-inline">
            <option value="" {{ $statusFilter == null ? 'selected' : '' }}>Pending</option>
            <option value="scheduled" {{ $statusFilter == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="cancelled" {{ $statusFilter == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </form>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($statusFilter == 'scheduled' || $statusFilter == 'cancelled')
        {{-- ✅ Appointments Table --}}
        @if($appointments->isEmpty())
            <div class="alert alert-info">No {{ ucfirst($statusFilter) }} appointments found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient</th>
                            <th>Test</th>
                            <th>Rider</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appt)
                        <tr>
                            <td>{{ $appt->id }}</td>
                            <td>{{ $appt->testRequest->name ?? 'N/A' }}</td>
                            <td>{{ $appt->testRequest->test_name ?? 'N/A' }}</td>
                            <td>{{ $appt->rider->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y h:i A') }}</td>
                            <td><span class="badge bg-{{ $appt->status == 'cancelled' ? 'danger' : 'success' }}">{{ ucfirst($appt->status) }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    @else
        {{-- ✅ Pending Test Requests Table --}}
        @if($testRequests->isEmpty())
            <div class="alert alert-info">No pending online test requests found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Test</th>
                            <th>Date/Time</th>
                            <th>Rider / Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($testRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ $request->test_name ?? 'Online Test' }}</td>
                            <td>
                                <input type="datetime-local"
                                    name="appointment_date"
                                    form="assign-form-{{ $request->id }}"
                                    class="form-control"
                                    required>
                            </td>
                            <td>
                                <form id="assign-form-{{ $request->id }}"
                                    method="POST"
                                    action="{{ route('branchadmin.appointments.assign', $request->id) }}">
                                    @csrf
                                    <select name="rider_id" class="form-select mb-2" required>
                                        <option value="">Select Rider</option>
                                        @foreach($riders as $rider)
                                            <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Assign</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
@endsection
