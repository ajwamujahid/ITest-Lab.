@extends('layouts.master')

@section('title', 'Inventory Reports')

@section('content')
{{-- CSS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class=" m-0">
            <i class="bi bi-bar-chart-line me-2"></i> Inventory Reports
        </h3>
    </div>

            {{-- Page Header --}}
           
            {{-- Report Filter Form --}}
            <form method="POST" action="{{ route('inventory.reports.generate') }}" class="mb-4">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Report Type</label>
                        <select name="report_type" class="form-select select2" required>
                            <option value="">-- Select Report --</option>
                            <option value="stock_summary" {{ request('report_type') == 'stock_summary' ? 'selected' : '' }}>Stock Summary</option>
                            <option value="low_stock" {{ request('report_type') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="expired_items" {{ request('report_type') == 'expired_items' ? 'selected' : '' }}>Expired Items</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label ">Category</label>
                        <select name="category_id" class="form-select select2">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Branch</label>
                        <select name="branch_id" class="form-select  select2">
                            <option value="">All Branches</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary shadow-sm w-100">
                            <i class="bi bi-graph-up-arrow me-1"></i> Generate
                        </button>
                    </div>
                </div>

                {{-- Optional: Uncomment for date filtering --}}
                {{-- 
                <div class="row g-3 mt-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" class="form-control shadow-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" class="form-control shadow-sm" value="{{ request('end_date') }}">
                    </div>
                </div>
                --}}
            </form>

    <div class="card  rounded-4">
        <div class="card-body p-4">

            {{-- Report Results --}}
            @if(isset($items))
              
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class=" m-0">Report Results</h5>
                    <div>
                        <a href="#" onclick="window.print()" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="bi bi-printer me-1"></i> Print
                        </a>
                        {{-- Optional: PDF Export --}}
                        {{-- <a href="{{ route('inventory.reports.export', request()->all()) }}" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                        </a> --}}
                    </div>
                </div>

                @if($items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="reportTable">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Branch</th>
                                    <th>Expiry</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="text-center">
                                        <td class="">{{ $item->id }}</td>
                                        <td class="">{{ $item->item_name }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ $item->branch->name ?? 'Main' }}</td>
                                        <td>{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            @if($item->quantity == 0)
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @elseif($item->quantity < 10)
                                                <span class="badge bg-warning text-dark">Low Stock</span>
                                            @else
                                                <span class="badge bg-success">In Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning text-center">No items found for selected filters.</div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection

{{-- JS --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Select an option',
            width: '100%',
            allowClear: true
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#reportTable').DataTable({
            pageLength: 25,
            order: [[0, 'asc']],
        });
    });
</script>
@endpush
