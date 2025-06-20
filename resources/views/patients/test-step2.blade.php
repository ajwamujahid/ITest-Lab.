@extends('layouts.patient-master')
@section('title', 'Step 2: Select Tests')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Step 2: Select Tests</h2>

    <form action="{{ route('test.final.post') }}" method="POST">
        @csrf

        <div class="mb-4">
            @foreach($testsGrouped as $branchName => $tests)
                <h5>{{ $branchName }}</h5>
                <div class="row">
                    @foreach($tests as $test)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input test-checkbox" type="checkbox" name="tests[]" value="{{ $test->id }}" data-price="{{ $test->price }}">
                                <label class="form-check-label">{{ $test->name }} (Rs {{ $test->price }})</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
            @endforeach
        </div>

        <div class="mb-3">
            <label>Select Branch</label>
            <select name="branch" class="form-control" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Online">Online</option>
            </select>
        </div>

        <div class="mb-4">
            <strong>Total: Rs <span id="totalAmount">0.00</span></strong>
        </div>

        <button  type="submit" class="btn btn-success">Submit Test Request</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.test-checkbox:checked').forEach(function (checkbox) {
                total += parseFloat(checkbox.dataset.price);
            });
            document.getElementById('totalAmount').innerText = total.toFixed(2);
        }

        document.querySelectorAll('.test-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('change', updateTotal);
        });

        updateTotal();
    });
</script>
@endsection
