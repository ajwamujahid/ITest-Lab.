@extends('layouts.master')

@section('content')
<div class="container">
    <h4 class="mb-4">💰 Payments</h4>

    <form method="GET" class="mb-3 row g-3">
        <div class="col-md-4">
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-4">
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">🔍 Filter</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Status</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->patient_name }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->payment_mode }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $payments->withQueryString()->links() }}
</div>
@endsection
