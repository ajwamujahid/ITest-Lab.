@extends('layouts.branch-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- 🧾 Heading --}}
                    <h3 class="mb-4 text-center text-primary fw-bold">
                       Add New Expense
                    </h3>

                    {{-- 🚨 Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>There were some problems with your input:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- 📋 Form --}}
                    <form method="POST" action="{{ route('branchadmin.expenses.store') }}">
                        @csrf
                        <div class="row g-3">
                            {{-- Amount --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Amount (Rs.)</label>
                                <input type="number" name="amount" step="0.01" class="form-control" required>
                            </div>

                            {{-- Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Expense Date</label>
                                <input type="date" name="expense_date" class="form-control" required>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Category (Optional)</label>
                                <input type="text" name="category" class="form-control" placeholder="e.g. Transport, Utility">
                            </div>

                            {{-- Description --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Description (Optional)</label>
                                <input type="text" name="description" class="form-control" placeholder="Any short note">
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-success px-4">
                                 Save Expense
                            </button>
                            <a href="{{ route('branchadmin.expenses.index') }}" class="btn btn-secondary ms-2">
                                Back
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
