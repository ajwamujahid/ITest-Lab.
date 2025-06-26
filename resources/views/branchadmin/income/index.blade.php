@extends('layouts.branch-master')

@section('content')
<div class="container py-4">
    {{-- Heading --}}
    <h3 class="mb-4 fw-bold text-primary">
        <i class="bi bi-cash-coin me-2"></i>Branch Income
    </h3>

    {{-- Add Button --}}
    <a href="{{ route('income.create') }}" class="btn btn-primary mb-3">
        Add Income
    </a>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Income Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Source</th>
                    <th>Amount</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomes as $income)
                <tr>
                    <td>{{ $income->income_date }}</td>
                    <td>{{ $income->source }}</td>
                    <td>Rs. {{ number_format($income->amount, 2) }}</td>
                    <td>{{ $income->note }}</td>
                    <td>
                        <a href="{{ route('income.edit', $income->id) }}" class="btn btn-sm btn-warning">
                           
                        </a>
                        <form action="{{ route('income.destroy', $income->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this income?')">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No income records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
