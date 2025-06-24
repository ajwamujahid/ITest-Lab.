@extends('layouts.master')

@section('title', 'Add Inventory Item')

@section('content')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-5">
    
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 rounded-4">

                @if(session('success'))
                    <div class="alert alert-success text-center mt-3 mx-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card-body p-4">
                    <h3 class="mb-4 text-center text-primary fw-bold">Add Inventory Item</h3>
                    <div class="card-body p-4">
                       
                    

                    <form method="POST" action="{{ route('inventory.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="item_name" value="{{ old('item_name') }}" class="form-control @error('item_name') is-invalid @enderror" placeholder="Enter item name" required>
                            @error('item_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SKU / Barcode</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="form-control shadow-sm @error('sku') is-invalid @enderror" placeholder="Scan or enter SKU" required>
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select select2 @error('category_id') is-invalid @enderror" required>
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
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control  @error('quantity') is-invalid @enderror" placeholder="e.g. 50" required>
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Unit</label>
                                <input type="text" name="unit" value="{{ old('unit') }}" class="form-control @error('unit') is-invalid @enderror" placeholder="e.g., boxes, liters" required>
                                @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Branch</label>
                            <select name="branch_id" class="form-select select2 @error('branch_id') is-invalid @enderror" required>
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
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date') }}">

                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Supplier Info</label>
                                <input type="text" name="supplier" value="{{ old('supplier') }}" class="form-control shadow-sm" placeholder="Optional">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                 Add Item
                                 
                            </button>
                          
                                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                                    Back to Items
                                </a>
                               
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
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

    function validateForm() {
        let isValid = true;
        let requiredFields = ['item_name', 'sku', 'category_id', 'quantity', 'unit', 'branch_id'];

        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input && input.value.trim() === '') {
                input.classList.add('is-invalid');
                isValid = false;
            } else if (input) {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            alert('Please fill out all required fields.');
        }

        return isValid;

    }
   
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const minDate = `${yyyy}-${mm}-${dd}`;

        document.getElementById('expiry_date').setAttribute('min', minDate);
    });


</script>
@endpush
