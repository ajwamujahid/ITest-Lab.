@extends('layouts.master')

@section('title', 'Finance | Total Expenses')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-4">

    <h2 class="mb-4">Total Expenses</h2>

    {{-- 🔎 Filter Form --}}
    <form method="GET" action="{{ url('finance/expenses') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label for="branch" class="form-label">Branch</label>
                <select id="branch" name="branch" class="form-select select2">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                
                @error('branch_id') 
                    <small class="text-danger">{{ $message }}</small> 
                @enderror
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </div>
        </div>
    </form>

    {{-- 💰 Summary Box --}}
    <div class="mb-4">
        <div class="card shadow-sm border-0 bg-light p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-1">Total Expenses</h5>
                    <h3 class="text-danger fw-bold">PKR {{ number_format($totalExpenses, 2) }}</h3>
                </div>
                <div>
                    <i class="bi bi-credit-card fs-1 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 📋 Expenses Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-black fw-semibold">
             Expense Records
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Amount (PKR)</th>
                        <th>Date</th>
                        <th>Branch</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage() }}</td>
                            <td>{{ $expense->description }}</td>
                            <td class="fw-semibold">PKR {{ number_format($expense->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y') }}</td>
                            <td>{{ $expense->branch->name ?? 'N/A' }}</td>
                            <td>{{ $expense->category ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No expenses found for the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $expenses->withQueryString()->links() }}
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