@extends('layouts.branch-master')

@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center text-primary fw-bold">Report Low Stock</h3>

                    {{-- ✅ Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- 📋 Form --}}
                    <form action="{{ route('low.stock.report.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- Branch --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Select Branch</label>
                                <select name="branch_id" id="branch_id" class="form-select select2" required>
                                    <option value="">-- Select Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Item --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Select Item</label>
                                <select name="item_id" id="item_id" class="form-select select2" required>
                                    <option value="">-- Select Item --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Quantity Reported</label>
                                <input type="number" name="quantity_reported" class="form-control" required min="0" placeholder="e.g. 5">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                                Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- jQuery & Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                placeholder: "Select option",
                allowClear: true
            });
        });
    </script>
@endpush
