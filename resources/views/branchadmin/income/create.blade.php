@extends('layouts.branch-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card rounded-4 shadow-sm border-0">
                <div class="card-body p-4">

                    <h3 class="mb-4 text-center text-primary">
                        Add New Income
                    </h3>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('income.store') }}">
                        @csrf

                        {{-- You can make branch_id dynamic --}}
                        <input type="hidden" name="branch_id" value="1">

                        <div class="row g-3">
                            {{-- Source --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Income Source</label>
                                <input type="text" name="source" class="form-control" required placeholder="e.g. Lab Service">
                            </div>

                            {{-- Amount --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Amount (Rs.)</label>
                                <input type="number" name="amount" class="form-control" required placeholder="e.g. 5000">
                            </div>

                            {{-- Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Income Date</label>
                                <input type="date" name="income_date" class="form-control" required>
                            </div>

                            {{-- Note --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Note (Optional)</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Any remarks or details..."></textarea>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-success px-4">
                                Save Income
                            </button>
                            <a href="{{ route('income.index') }}" class="btn btn-secondary ms-2">
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
