@extends('layouts.patient-master')
@section('title', 'Invoice')

@push('styles')
<style>
    .invoice-box {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }
    .invoice-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #6c757d;
    }
    .invoice-info p {
        margin-bottom: 0.4rem;
    }
    .invoice-table th, .invoice-table td {
        vertical-align: middle;
    }
    .invoice-total {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
    }

    /* Hide elements when printing */
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-box, .invoice-box * {
            visibility: visible;
        }
        .invoice-box {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .print-hide {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Action Buttons --}}
            <div class="d-flex justify-content-end gap-2 mb-3 print-hide">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <button class="btn btn-primary" onclick="downloadPDF()">
                    <i class="bi bi-download me-1"></i> Download PDF
                </button>
            </div>

            {{-- Invoice --}}
            <div class="invoice-box p-4">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center p-3 mb-4 border-bottom">
                    <h4 class="mb-0">Invoice #{{ $invoice->invoice_number }}</h4>
                    <span>{{ $invoice->created_at->format('d M, Y') }}</span>
                </div>

                {{-- Branch Info --}}
                <div class="mb-4">
                    <div class="invoice-section-title mb-2">Branch Information</div>
                    @if($branch)
                    <div class="invoice-info">
                        <p><strong>Name:</strong> {{ $branch->name }}</p>
                        <p><strong>Zip Code:</strong> {{ $branch->zip_code ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ $branch->city ?? 'N/A' }}</p>
                        <p><strong>State:</strong> {{ $branch->state ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $branch->country ?? 'N/A' }}</p>
                    </div>
                @else
                    <p class="text-danger">Branch info not available.</p>
                @endif
                
                </div>

                {{-- Patient Info --}}
                <div class="mb-4">
                    <div class="invoice-section-title mb-2">Patient Information</div>
                    <div class="invoice-info">
                        <p><strong>Name:</strong> {{ $patient->name }}</p>
                        <p><strong>Email:</strong> {{ $patient->email }}</p>
                        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($patient->payment_method) }}</p>
                    </div>
                </div>

                {{-- Test Info --}}
                <div class="mb-4">
                    <div class="invoice-section-title mb-3">Selected Tests</div>
                    <div class="table-responsive">
                        <table class="table table-bordered invoice-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Test</th>
                                    <th>Type</th>
                                    <th class="text-end">Price (Rs)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($selectedTests as $test)
                                    <tr>
                                        <td>{{ $test['name'] }}</td>
                                        <td>{{ ucfirst($test['type']) }}</td>
                                        <td class="text-end">{{ number_format($test['price'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No tests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Total --}}
                <div class="d-flex justify-content-end mb-4">
                    <div class="invoice-total">
                        Total Amount: Rs {{ number_format($invoice->amount, 2) }}
                    </div>
                </div>

                {{-- Back Button --}}
                <div class="text-start print-hide">
                    <a href="{{ route('test.step1') }}" class="btn btn-secondary">
                         Back to Test Form
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- html2pdf.js for PDF download --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadPDF() {
        const element = document.querySelector('.invoice-box');
        const opt = {
            margin:       0.5,
            filename:     'invoice-{{ $invoice->invoice_number }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
@endpush
