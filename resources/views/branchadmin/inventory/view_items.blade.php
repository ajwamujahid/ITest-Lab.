@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h3 class="mt-4 text-primary fw-bold">
        <i class="bx bx-package me-2"></i> Inventory - Your Branch
    </h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Expiry</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->category->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
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
            @empty
                <tr>
                    <td colspan="7">No items found for your branch.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $items->links() }}
</div>
@endsection
