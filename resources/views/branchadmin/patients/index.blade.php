@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h1>Patient Appointments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Test Name(s)</th>
                <th>Appointment Date</th>
                <th>Assigned Rider</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>

                <td>{{ optional($appointment->testRequest)->name ?? 'N/A' }}</td>
                <td>
                    @php
                        $testIds = [];
                
                        // safely decode if exists
                        if (!empty($appointment->testRequest) && $appointment->testRequest->tests) {
                            $testIds = is_array($appointment->testRequest->tests)
                                ? $appointment->testRequest->tests
                                : json_decode($appointment->testRequest->tests, true);
                        }
                    @endphp
                
                    @if(!empty($testIds) && is_array($testIds))
                        @foreach ($testIds as $testId)
                            {{ $tests->get($testId)->name ?? "Test ID $testId not found" }}<br>
                        @endforeach
                    @else
                        N/A
                    @endif
                </td>
                
                <td>
                    @if ($appointment->appointment_date)
                        <span class="badge bg-success">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y, h:i A') }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Not Assigned</span>
                    @endif
                </td>

                <td>
                    @if ($appointment->rider)
                        <span class="badge bg-info">{{ $appointment->rider->name }}</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>

                <td>
                    <!-- Form for assigning appointment -->
                    <form action="{{ route('branchadmin.appointments.assign', $appointment->id) }}" method="POST">

                    @csrf

                        <!-- Appointment Date Picker -->
                        <input type="datetime-local"
                            name="appointment_date"
                            class="form-control mb-2"
                            value="{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') : '' }}"
                            required>

                        <!-- Rider Select Dropdown -->
                        <select name="rider_id" class="form-control mb-2" required>
                            <option value="">Select Rider</option>
                            @foreach($riders as $rider)
                                <option value="{{ $rider->id }}" {{ $appointment->rider_id == $rider->id ? 'selected' : '' }}>
                                    {{ $rider->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6">No Appointments Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-3">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
