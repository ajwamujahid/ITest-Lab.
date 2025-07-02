@extends('layouts.patient-master')
@section('title', 'Step 2: Select Tests')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    #card-element {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 12px;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <form id="finalTestForm" method="POST">
        @csrf

        {{-- Tests --}}
        @foreach($testsGrouped as $branchName => $tests)
            <h5>{{ $branchName }}</h5>
            @foreach($tests as $test)
                <div>
                    <input type="checkbox" name="tests[]" class="test-checkbox"
                        value="{{ $test->id }}" data-price="{{ $test->price }}">
                    {{ $test->name }} (Rs {{ $test->price }})
                </div>
            @endforeach
            <hr>
        @endforeach

        {{-- Branch --}}
        <div>
            <label>Branch</label>
            <select name="branch" class="form-select select2" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Payment Method --}}
        <div>
            <label>Payment Method</label>
            <select name="payment_method" id="paymentMethod" class="form-select" required>
                <option value="">Select</option>
                <option value="Cash">Cash</option>
                <option value="Stripe">Stripe</option>
            </select>
        </div>

        {{-- Stripe Card --}}
        <div id="stripeCardContainer" style="display:none">
            <label>Card Details</label>
            <div id="card-element"></div>
            <div id="card-errors" class="text-danger mt-2"></div>
        </div>

        <h5>Total: Rs <span id="totalAmount">0.00</span></h5>

        <div>
            <button type="button" id="submitTestBtn" class="btn btn-primary">Submit</button>
            <button type="button" id="payNowBtn" class="btn btn-success" style="display:none">Pay Now</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let stripe = Stripe("{{ env('STRIPE_KEY') }}");
let elements = stripe.elements();
let cardElement = elements.create('card');
let clientSecret = null;

// Update Total
function updateTotal() {
    let total = 0;
    $('.test-checkbox:checked').each(function () {
        total += parseFloat($(this).data('price'));
    });
    $('#totalAmount').text(total.toFixed(2));
}
$('.test-checkbox').on('change', updateTotal);
updateTotal();

// Show/hide Stripe card input based on payment method
$('#paymentMethod').on('change', function () {
    if ($(this).val() === 'Stripe') {
        $('#stripeCardContainer, #payNowBtn').show();
        $('#submitTestBtn').hide();
        createStripeIntent();
    } else {
        $('#stripeCardContainer, #payNowBtn').hide();
        $('#submitTestBtn').show();
    }
});

// Create PaymentIntent from backend
function createStripeIntent() {
    const selectedTests = $('.test-checkbox:checked').map(function () {
        return $(this).val();
    }).get();

    if (!selectedTests.length) {
        Swal.fire('Please select at least one test.');
        return;
    }

    fetch("{{ route('stripe.payment.intent') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("input[name=_token]").val()
        },
        body: JSON.stringify({ tests: selectedTests })
    })
    .then(res => res.json())
    .then(data => {
        clientSecret = data.clientSecret;
        cardElement.mount("#card-element");
    });
}

// Handle Stripe Payment
$('#payNowBtn').on('click', async function () {
    const branch = $('select[name="branch"]').val();
    const tests = $('.test-checkbox:checked').map(function () {
        return $(this).val();
    }).get();

    if (!branch || !tests.length) {
        return Swal.fire('Missing Info', 'Please select tests and branch.', 'warning');
    }

    // Save session before payment
    await fetch("{{ route('test.final.post') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $("input[name=_token]").val()
        },
        body: JSON.stringify({
            tests: tests,
            branch: branch,
            payment_method: 'Stripe'
        })
    });

    // Confirm card payment
    const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: cardElement
        }
    });

    if (error) {
        $('#card-errors').text(error.message);
    } else if (paymentIntent.status === 'succeeded') {
        Swal.fire({
            title: 'Success',
            text: 'Payment Successful. Redirecting to invoice...',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        });

        // Final call to generate invoice
        fetch("{{ route('test.stripe.success') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $("input[name=_token]").val()
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.invoice_id) {
                window.location.href = `/invoice/${data.invoice_id}`;
            } else {
                Swal.fire('Error', data.error || 'Invoice creation failed.', 'error');
            }
        });
    }
});

// Handle normal cash form submit
$('#submitTestBtn').on('click', function () {
    const payment = $('#paymentMethod').val();
    if (payment === 'Stripe') {
        Swal.fire('Please use "Pay Now" button for Stripe payment.');
    } else {
        $('#finalTestForm').attr('action', "{{ route('test.final.post') }}").submit();
    }
});
</script>
@endpush
