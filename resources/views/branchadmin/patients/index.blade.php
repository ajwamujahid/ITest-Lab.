@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h1>Patient Appointments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Online Test(s)</th>
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
               {{-- Debug --}}
{{-- <pre>
    Decoded Tests:
    {{ print_r($decodedTests ?? 'N/A', true) }}
    
    Loaded Online Tests:
    {{ print_r($tests->keys(), true) }}
    </pre> --}}
    
                <td>
                    @php
                        $onlineTestNames = [];
                
                        if (!empty($appointment->testRequest) && $appointment->testRequest->tests) {
                            $testsData = $appointment->testRequest->tests;
                
                            // ✅ Agar string hai to decode karo
                            if (is_string($testsData)) {
                                $decodedTests = json_decode($testsData, true);
                            } else {
                                $decodedTests = $testsData;
                            }
                
                            foreach ($decodedTests as $testObj) {
                                if (isset($testObj['id']) && isset($tests[$testObj['id']])) {
                                    $onlineTestNames[] = $tests[$testObj['id']]->name;
                                }
                            }
                        }
                    @endphp
                
                    @if(!empty($onlineTestNames))
                        {!! implode('<br>', $onlineTestNames) !!}
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
                    <form action="{{ route('branchadmin.appointments.assign', $appointment->id) }}" method="POST">
                        @csrf

                        <input type="datetime-local"
                            name="appointment_date"
                            class="form-control mb-2"
                            value="{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') : '' }}"
                            required>

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

    <div class="mt-3">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
