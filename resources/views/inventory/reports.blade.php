@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Inventory Reports</h2>

    <form method="POST" action="{{ route('inventory.reports.generate') }}" class="mb-4">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="report_type" class="form-label">Select Report Type</label>
                <select name="report_type" id="report_type" class="form-select" required>
                    <option value="">-- Select Report --</option>
                    <option value="stock_summary" {{ (isset($reportType) && $reportType=='stock_summary') ? 'selected' : '' }}>Stock Summary</option>
                    <option value="low_stock" {{ (isset($reportType) && $reportType=='low_stock') ? 'selected' : '' }}>Low Stock</option>
                    <option value="expired_items" {{ (isset($reportType) && $reportType=='expired_items') ? 'selected' : '' }}>Expired Items</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (isset($categoryId) && $categoryId == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="branch_id" class="form-label">Branch</label>
                <select name="branch_id" id="branch_id" class="form-select">
                    <option value="">All Branches</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ (isset($branchId) && $branchId == $branch->id) ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Optional Date Range, useful for future movement reports --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    @if(isset($items) && $items->count() > 0)
        <h4>Report Results:</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Branch</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->branch->name ?? 'Main' }}</td>
                        <td>{{ $item->expiry_date ? $item->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            @if($item->quantity == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($item->quantity < 10)
                                <span class="badge bg-warning">Low Stock</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($items))
        <p>No records found for the selected criteria.</p>
    @endif
</div>
@endsection
