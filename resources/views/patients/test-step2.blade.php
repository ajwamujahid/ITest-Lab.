@extends('layouts.patient-master')
@section('title', 'Step 2: Select Tests')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center text-primary mb-4">Step 2: Select Your Tests</h2>

                    <form id="finalTestForm" action="{{ route('test.final.post') }}" method="POST">
                        @csrf

                        {{-- Test List Grouped by Branch --}}
                        <div class="mb-4">
                            @foreach($testsGrouped as $branchName => $tests)
                                <h5 class="text-secondary mb-3">{{ $branchName }}</h5>
                                <div class="row g-2">
                                    @foreach($tests as $test)
                                        <div class="col-md-4">
                                            <div class="form-check px-3 py-2">
                                                <input class="form-check-input test-checkbox" type="checkbox"
                                                       name="tests[]" id="test{{ $test->id }}"
                                                       value="{{ $test->id }}" data-price="{{ $test->price }}">
                                                <label class="form-check-label" for="test{{ $test->id }}">
                                                    {{ $test->name }} <span class="text-muted">(Rs {{ $test->price }})</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="my-4">
                            @endforeach
                        </div>

                        {{-- Select Branch --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Branch</label>
                            <select name="branch" class="form-select select2" required>
                                <option value="">-- Choose Branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Method</label>
                            <select name="payment_method" class="form-select select2" required>
                                <option value="">Select Payment Option</option>
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>

                        {{-- Total Amount --}}
                        <div class="mb-4 text-end">
                            <h5><strong>Total: Rs <span id="totalAmount">0.00</span></strong></h5>
                        </div>

                        {{-- Submit & Back --}}
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" id="submitTestBtn">
                                Submit Test Request
                            </button>
                            <a href="{{ route('test.step1') }}" class="btn btn-outline-secondary">
                                Back to info
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateTotal = () => {
            let total = 0;
            document.querySelectorAll('.test-checkbox:checked').forEach(cb => {
                total += parseFloat(cb.dataset.price || 0);
            });
            document.getElementById('totalAmount').innerText = total.toFixed(2);
        };

        // Run on load
        updateTotal();

        // Update total on checkbox change
        document.querySelectorAll('.test-checkbox').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        // Enable Select2
        $('.select2').select2({
            placeholder: 'Select an option',
            width: '100%',
            allowClear: true
        });

        // Handle submission via SweetAlert
        document.getElementById('submitTestBtn').addEventListener('click', function () {
            const form = document.getElementById('finalTestForm');
            const selectedTests = document.querySelectorAll('.test-checkbox:checked');
            const branch = document.querySelector('select[name="branch"]').value;
            const payment = document.querySelector('select[name="payment_method"]').value;

            let errors = [];

            if (!branch) errors.push("Please select a branch.");
            if (!payment) errors.push("Please select a payment method.");
            if (selectedTests.length === 0) errors.push("Please select at least one test.");

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    html: errors.join('<br>'),
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit your test request?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Submit',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
