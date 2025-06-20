@extends('layouts.patient-master')
@section('title', 'Invoice')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Invoice #{{ $invoice->invoice_number }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Branch:</strong> {{ \App\Models\Branch::find($invoice->branch_id)?->name }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>

            <hr>

            <h5>Patient Info</h5>
            <h2>Invoice for {{ $patient->name }}</h2>
            <p>Email: {{ $patient->email }}</p>
            <p>Phone: {{ $patient->phone }}</p>
            
            <p><strong>Payment Method:</strong> {{ $patient->payment_method }}</p>

            <h5 class="mt-4">Selected Tests</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Test</th>
                        <th>Price (Rs)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($selectedTests) && count($selectedTests) > 0)
                    @foreach($selectedTests as $test)
                    <tr>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->price }}</td>
                    </tr>
                @endforeach
                
                
                @else
                    <tr><td colspan="2">No tests found</td></tr>
                @endif
                
                    
                </tbody>
            </table>

            <h4 class="mt-3">Total: Rs {{ number_format($invoice->amount, 2) }}</h4>
        </div>
    </div>
</div>
@endsection
