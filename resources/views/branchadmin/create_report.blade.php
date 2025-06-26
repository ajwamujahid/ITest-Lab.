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
                    <h3 class="mb-4 text-center text-primary fw-bold">Create Inventory Report</h3>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('branchadmin.inventory.report.store') }}">
                        @csrf
                        <div class="row g-3">
                            {{-- Report Type --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Report Type</label>
                                <select name="report_type" class="form-select select2" required>
                                    <option value="">-- Select Report Type --</option>
                                    <option value="stock_summary">Stock Summary</option>
                                    <option value="low_stock">Low Stock</option>
                                    <option value="expired_items">Expired Items</option>
                                </select>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Select Category</label>
                                <select name="category_id" id="category_id" class="form-select select2" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Items --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Select Items</label>
                                <select name="item_ids[]" id="item_ids" class="form-select select2" multiple required>
                                    <option disabled>Select Items</option>
                                </select>
                            </div>

                            {{-- Report Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Report Date</label>
                                <input type="date" name="report_date" class="form-control" required>
                            </div>

                            {{-- Notes --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Additional Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Write any relevant notes..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">Submit Report</button>
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
                placeholder: "Select",
                allowClear: true
            });

            $('#category_id').on('change', function () {
                let categoryId = $(this).val();
                let itemSelect = $('#item_ids');

                itemSelect.empty();

                if (categoryId) {
                    $.ajax({
                        url: '{{ route("branchadmin.inventory.items.by.category") }}',
                        type: 'GET',
                        data: { category_id: categoryId },
                        success: function (data) {
                            if (data.length) {
                                data.forEach(item => {
                                    itemSelect.append(`<option value="${item.id}">${item.item_name} (${item.sku})</option>`);
                                });
                            } else {
                                itemSelect.append('<option disabled>No items found for this category</option>');
                            }
                        },
                        error: function () {
                            alert("Unable to load items. Please try again.");
                        }
                    });
                }
            });
        });
    </script>
@endpush
