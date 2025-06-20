@extends('layouts.master')

@section('title', 'Inventory Items List')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Inventory Items</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="branch" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="itemsTable">
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
                @foreach($items as $item)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->sku }}</td>
                    <td>
                        @if($item->category)
                            <span class="badge bg-primary">{{ $item->category->name }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($item->quantity < 10)
                            <span class="badge bg-danger">{{ $item->quantity }} (Low)</span>
                        @else
                            {{ $item->quantity }}
                        @endif
                    </td>
                    
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->branch->name ?? 'N/A' }}</td>
                    <td>{{ $item->expiry_date ?? 'N/A' }}</td>
                    <td>{{ $item->supplier ?? 'N/A' }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info">View</a>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Use DataTables if you want search/pagination
    $(document).ready(function () {
        $('#itemsTable').DataTable();
    });
</script>
@endpush
