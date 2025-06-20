@extends('layouts.branch-master')

@section('content')
<div class="container mt-4">
    <h2>Create Inventory Report</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('branchadmin.inventory.report.store') }}">
        @csrf

        <div class="mb-3">
            <label for="report_type" class="form-label">Report Type</label>
            <select name="report_type" class="form-select" required>
                <option value="">-- Select Report Type --</option>
                <option value="stock_summary">Stock Summary</option>
                <option value="low_stock">Low Stock</option>
                <option value="expired_items">Expired Items</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Select Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="item_ids" class="form-label">Select Items</label>
            <select name="item_ids[]" id="item_ids" class="form-select" multiple required></select>
        </div>
        

        <div class="mb-3">
            <label for="report_date" class="form-label">Report Date</label>
            <input type="date" name="report_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Additional Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Report</button>
    </form>
</div>
@push('scripts')
<!-- Include jQuery + Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    $('#item_ids').select2({ placeholder: "Select items", width: '100%' });

    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        $('#item_ids').empty(); // clear previous options

        if (categoryId) {
            $.ajax({
                url: '{{ route("branchadmin.inventory.items.by.category") }}',
                type: 'GET',
                data: { category_id: categoryId },
                success: function (data) {
                    $('#item_ids').append(`<option disabled selected>Select Items</option>`);
                    data.forEach(function (item) {
                        $('#item_ids').append(`<option value="${item.id}">${item.item_name} (${item.sku})</option>`);
                    });
                },
                error: function (xhr) {
                    alert("Failed to load items!");
                }
            });
        }
    });
});
</script>
@endpush

@endsection
