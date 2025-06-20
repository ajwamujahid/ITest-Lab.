@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">📦 Inventory Stock Levels</h2>

    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <select name="branch_id" class="form-control">
                <option value="">All Branches</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" type="submit">🔍 Filter</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
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
                    <td>{{ $item->item_name }}</td>
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
                    <td colspan="6" class="text-center">No items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
