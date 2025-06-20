@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">Invoices</h3>

    <!-- Filter -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Branch</label>
                <select name="branch_id" class="form-select">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Filter</button>
            </div>
        </div>
    </form>

    <!-- Quick Filters -->
    <div class="mb-3 d-flex flex-wrap gap-2">
        <a href="{{ route('invoices.index', ['from_date' => now()->startOfDay()->format('Y-m-d'), 'to_date' => now()->endOfDay()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">Today</a>

        <a href="{{ route('invoices.index', ['from_date' => now()->startOfWeek()->format('Y-m-d'), 'to_date' => now()->endOfWeek()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">This Week</a>

        <a href="{{ route('invoices.index', ['from_date' => now()->startOfMonth()->format('Y-m-d'), 'to_date' => now()->endOfMonth()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">This Month</a>
    </div>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice No</th>
                <th>Branch</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->branch->name }}</td>
                    <td>{{ number_format($invoice->amount, 2) }}</td>
                    <td>{{ $invoice->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No invoices found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $invoices->withQueryString()->links() }}
</div>
@endsection
