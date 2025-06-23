@extends('layouts.master')

@section('title', 'Add Inventory Item')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card border-0 shadow rounded-4">

                @if(session('success'))
                    <div class="alert alert-success text-center mt-3 mx-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card-body p-4">
                    <h3 class="mb-4 text-center text-primary fw-bold">Add Inventory Item</h3>

                    <form method="POST" action="{{ route('inventory.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="item_name" value="{{ old('item_name') }}" class="form-control shadow-sm @error('item_name') is-invalid @enderror" placeholder="Enter item name" required>
                            @error('item_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">SKU / Barcode <span class="text-danger">*</span></label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="form-control shadow-sm @error('sku') is-invalid @enderror" placeholder="Scan or enter SKU" required>
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select shadow-sm @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control shadow-sm @error('quantity') is-invalid @enderror" placeholder="e.g. 50" required>
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
                                <input type="text" name="unit" value="{{ old('unit') }}" class="form-control shadow-sm @error('unit') is-invalid @enderror" placeholder="e.g., boxes, liters" required>
                                @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Branch <span class="text-danger">*</span></label>
                            <select name="branch_id" class="form-select shadow-sm @error('branch_id') is-invalid @enderror" required>
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Expiry Date</label>
                                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Supplier Info</label>
                                <input type="text" name="supplier" value="{{ old('supplier') }}" class="form-control shadow-sm" placeholder="Optional">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                                 Add Item
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
