@extends('layouts.patient-master')
@section('title', 'Invoice')

@section('content')

<div class="container py-5">


    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
                    <h4 class="mb-0">🧾 Invoice #{{ $invoice->invoice_number }}</h4>
                    <span>{{ $invoice->created_at->format('d M, Y') }}</span>
                </div>

                <div class="card-body p-4">

                    {{-- Branch Info --}}
                    <div class="mb-4">
                      {{-- Branch Info --}}
@if($branch)
<div class="mb-4">
    <h5 class="mb-2 text-muted">🏥 Branch Information</h5>
    <p class="mb-1"><strong>Name:</strong> {{ $branch->name }}</p>
    <p class="mb-1"><strong>Zip Code:</strong> {{ $branch->zip_code ?? 'N/A' }}</p>
    <p class="mb-1"><strong>City:</strong> {{ $branch->city ?? 'N/A' }}</p>
    <p class="mb-1"><strong>State:</strong> {{ $branch->state ?? 'N/A' }}</p>
    <p class="mb-1"><strong>Country:</strong> {{ $branch->country ?? 'N/A' }}</p>
</div>
@else
    <p class="text-danger">Branch info not available.</p>
@endif

                    </div>

                    {{-- Patient Info --}}
                    <div class="mb-4">
                        <h5 class="text-muted mb-3">🧑‍⚕️ Patient Information</h5>
                        <p class="mb-1"><strong>Name:</strong> {{ $patient->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $patient->email }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $patient->phone }}</p>
                        <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($patient->payment_method) }}</p>
                    </div>

                    {{-- Test Details --}}
                    <div class="mb-4">
                        <h5 class="text-muted mb-3">🧪 Selected Tests</h5>

                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Test</th>
                                    <th class="text-end">Price (Rs)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($selectedTests as $test)
                                    <tr>
                                        <td>{{ $test->name }}</td>
                                        <td class="text-end">{{ number_format($test->price, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No tests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Total --}}
                    <div class="d-flex justify-content-end">
                        <h4><strong>Total Amount: Rs {{ number_format($invoice->amount, 2) }}</strong></h4>
                        
                    </div>
                    {{-- 🔙 Back Button --}}
<div class="text-start mt-4">
    <a href="{{ route('test.step1') }}" class="btn btn-secondary">
         Back to Test Form
    </a>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
