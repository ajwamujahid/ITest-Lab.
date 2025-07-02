@extends('layouts.patient-master')

@section('title', 'Payment Successful')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <h2 class="text-success">✅ Payment Successful!</h2>
        <p>Your test booking has been confirmed.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
    </div>
</div>
@endsection
