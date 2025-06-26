@extends('layouts.patient-master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-primary"><i class="bx bx-calendar-check"></i> Scheduled Appointments</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Test Type</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>

                    {{-- Test Type --}}
                    <td>
                        @if($appointment->test_type == 'physical')
                            <span class="badge bg-primary"> Physical Test</span>
                        @else
                            <span class="badge bg-warning text-dark"> Sample Test</span>
                        @endif
                    </td>

                    <td>{{ $appointment->appointment_date }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($appointment->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}" class="cancel-form">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                        </form>
                        
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No scheduled appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.cancel-form');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // prevent default form submit

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to cancel this appointment!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // submit the form manually
                    }
                });
            });
        });
    });
</script>
@endpush
