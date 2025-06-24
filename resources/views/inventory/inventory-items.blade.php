@extends('layouts.master')

@section('title', 'Inventory Items List')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">
        <i class="bi bi-box-seam me-2"></i>
        Inventory Items
    </h3>
    
        <a href="{{ route('inventory.create') }}" class="btn btn-primary  mb-3">Add New Item</a>
                      {{-- Filter Form --}}
                      <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select select2">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Branch</label>
                            <select name="branch" class="form-select select2">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-4 d-flex gap-2 align-items-end">
                            <button type="submit" class="btn btn-primary w-30">
                                {{-- <i class="bi bi-funnel-fill me-1"></i>  --}}
                                Filter
                            </button>
                            <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary w-30">
                                {{-- <i class="bi bi-x-circle me-1"></i>  --}}
                                Reset
                            </a>
                        </div>
                    </form>

    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card border-0">
                <div class="card-body p-4">

                   
                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center shadow-sm">{{ session('success') }}</div>
                    @endif


                    {{-- Inventory Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle"  id="itemsTable">
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
                                    <th>Supplier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $item->item_name }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>
                                            @if($item->category)
                                                <span class="badge bg-info">{{ $item->category->name }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->quantity < 10)
                                                <span class="badge bg-danger">{{ $item->quantity }} (Low)</span>
                                            @else
                                                <span class="badge bg-success">{{ $item->quantity }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ $item->branch->name ?? 'N/A' }}</td>
                                        <td>{{ $item->expiry_date ?? 'N/A' }}</td>
                                        <td>{{ $item->supplier ?? 'N/A' }}</td>
                                        <td class="d-flex justify-content-center gap-1">
                                            <a href="#" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="#" method="POST" onsubmit="return confirm('Delete this item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">No inventory items found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#itemsTable').DataTable();
    });
</script>
@endpush
