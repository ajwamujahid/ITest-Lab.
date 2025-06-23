@extends('layouts.patient-master')
@section('title', 'Step 2: Select Tests')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center text-primary mb-4">🧪 Step 2: Select Your Tests</h2>

                    <form action="{{ route('test.final.post') }}" method="POST">
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
                            <label class="form-label fw-semibold">🏢 Select Branch</label>
                            <select name="branch" class="form-select" required>
                                <option value="">-- Choose Branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">💳 Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="">-- Select Payment Option --</option>
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>

                        {{-- Total Amount --}}
                        <div class="mb-4 text-end">
                            <h5><strong>Total: Rs <span id="totalAmount" class="text-success">0.00</span></strong></h5>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4 py-2">🚀 Submit Test Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS to calculate total --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateTotal = () => {
            let total = 0;
            document.querySelectorAll('.test-checkbox:checked').forEach(cb => {
                total += parseFloat(cb.dataset.price || 0);
            });
            document.getElementById('totalAmount').innerText = total.toFixed(2);
        };

        document.querySelectorAll('.test-checkbox').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        updateTotal(); // initial load
    });
</script>
@endsection
