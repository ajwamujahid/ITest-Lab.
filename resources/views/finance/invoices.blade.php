@extends('layouts.master')

@section('title', 'Finance | Invoices')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-4">
    <h3 class="mb-4">
        <i class="bx bx-receipt me-2"></i> Invoice Management
    </h3>
    

    {{-- 🔎 Filter --}}
    <form method="GET" class="mb-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="branch" class="form-label">Branch</label>
            <select id="branch" name="branch" class="form-select select2">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    {{-- ⏱️ Quick Filters --}}
    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="{{ route('invoices.index', ['from_date' => now()->format('Y-m-d'), 'to_date' => now()->format('Y-m-d')]) }}" class="btn btn-outline-dark btn-sm">
            Today
        </a>
        <a href="{{ route('invoices.index', ['from_date' => now()->startOfWeek()->format('Y-m-d'), 'to_date' => now()->endOfWeek()->format('Y-m-d')]) }}" class="btn btn-outline-dark btn-sm">
             This Week
        </a>
        <a href="{{ route('invoices.index', ['from_date' => now()->startOfMonth()->format('Y-m-d'), 'to_date' => now()->endOfMonth()->format('Y-m-d')]) }}" class="btn btn-outline-dark btn-sm">
             This Month
        </a>
    </div>

    {{-- 📄 Invoice Table --}}
    <div class="table-responsive">
        <table class="table  align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Invoice No</th>
                    <th>Branch</th>
                    <th>Amount (PKR)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration + ($invoices->currentPage() - 1) * $invoices->perPage() }}</td>
                        <td class="fw-bold">{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->branch->name ?? 'N/A' }}</td>
                        <td>{{ number_format($invoice->amount, 2) }}</td>
                        <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No invoices found for selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-3">
        {{ $invoices->withQueryString()->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a branch",
            width: '100%',
            allowClear: true
        });
    });
</script>

@endpush