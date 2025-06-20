@extends('layouts.rider-master')

@section('content')
<div class="container py-4">
    <h3 class="text-primary mb-4 fw-bold"><i class="bx bx-map-pin"></i> Patient Visit Status</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Patient</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                    <tr>
                        <td>{{ $appt->patient->name ?? 'Deleted Patient' }}</td>
<td>{{ $appt->patient->phone ?? 'N/A' }}</td>

                        <td>
                            <span class="badge bg-info">{{ ucfirst($appt->visit_status ?? 'Pending') }}</span>
                        </td>
                        <td>
                            <form action="{{ route('rider.sample.update', $appt->id) }}" method="POST" class="d-flex">
                                @csrf
                                <select name="visit_status" class="form-select form-select-sm me-2" required>
                                    <option value="">Select</option>
                                    <option value="visited">Visited</option>
                                    <option value="sample_collected">Sample Collected</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
