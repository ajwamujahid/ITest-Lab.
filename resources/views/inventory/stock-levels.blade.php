@extends('layouts.master')

@section('title', 'Inventory Stock Levels')

@section('content')
{{-- CSS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-5">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0">
            <i class="bi bi-clipboard-data me-2"></i> Inventory Stock Levels
        </h3>
        
    </div>
   
         

            {{-- Filters --}}
            <form method="GET" class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Branch</label>
                    <select name="branch_id" class="form-select select2  shadow-sm">
                        <option value="">All Branches</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category_id" class="form-select  select2 shadow-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4  gap-3">
                    <button type="submit" class="btn btn-primary">
                        {{-- <i class="bi bi-funnel me-1"></i>  --}}
                        Filter
                    </button>
                    <a href="{{ route('inventory.stock-levels') }}" class="btn btn-secondary">
                        {{-- <i class="bi bi-x-circle me-1"></i>  --}}
                        Reset
                    </a>
                </div>
            </form>
    
    <div class="card  rounded-4">
        <div class="card-body p-4">


            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="stockTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Branch</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td class="">{{ $item->id }}</td>
                                <td class="">{{ $item->item_name }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td>{{ $item->branch->name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @if ($item->quantity == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif ($item->quantity < 10)
                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted text-center">No items found for selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#stockTable').DataTable({
            pageLength: 25,
            order: [[4, 'asc']] // Sort by Quantity
        });
    });
</script>
@endpush
