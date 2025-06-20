@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold text-primary">📋 Assign Physical Test Appointments</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($testRequests->count())
        <div class="scroll-container" style="max-height: 600px; overflow-y: auto;">
            @foreach($testRequests as $index => $req)
                <div class="card border border-light-subtle mb-4 rounded-3">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <strong>👤 {{ $req->name }}</strong> — {{ $req->phone }}
                        </div>
                        <small class="text-muted">{{ $req->address }}</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('physical-tests.assign') }}" class="row g-3 align-items-center">
                            @csrf
                            <input type="hidden" name="patient_id" value="{{ $req->patient_id }}">

                            {{-- Test Selection --}}
                            <div class="col-md-4">
                                <label class="form-label mb-1 text-muted small">Test</label>
                                <select name="test_type" class="form-select test-select" data-index="{{ $index }}" required>
                                    <option value="" disabled selected>Select test</option>
                                    @foreach($availableTests as $test)
                                        <option value="{{ $test->name }}" data-price="{{ $test->price }}">{{ $test->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Appointment Date --}}
                            <div class="col-md-4">
                                <label class="form-label mb-1 text-muted small">Appointment Date & Time</label>
                                <input type="datetime-local" name="appointment_date" class="form-control" required>
                            </div>

                            {{-- Price Display --}}
                            <div class="col-md-3">
                                <label class="form-label mb-1 text-muted small">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">Rs</span>
                                    <input type="text" class="form-control bg-light" id="display-price-{{ $index }}" placeholder="0" readonly>
                                    <input type="hidden" name="price" id="hidden-price-{{ $index }}">
                                </div>
                            </div>

                            {{-- Assign as Text Link --}}
                            <div class="col-md-1 text-center">
                                <label class="form-label mb-1 invisible">Assign</label>
                                <button type="submit" class="bg-transparent border-0 text-primary text-decoration-underline p-0 mt-1">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No pending physical test requests found.</div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.test-select').forEach(select => {
        select.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const price = selected.getAttribute('data-price') || '0';
            const index = this.getAttribute('data-index');

            document.getElementById('display-price-' + index).value = parseInt(price).toLocaleString();
            document.getElementById('hidden-price-' + index).value = price;
        });
    });
</script>
@endsection
