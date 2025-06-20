@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Report Low Stock</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('low.stock.report.store') }}" method="POST">
        @csrf
    
        <div class="form-group">
            <label for="branch_id">Select Branch</label>
            <select name="branch_id" id="branch_id" class="form-control" required>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="item_id">Select Item</label>
            <select name="item_id" id="item_id" class="form-control" required>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="quantity_reported">Quantity Reported</label>
            <input type="number" name="quantity_reported" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Submit Report</button>
    </form>
    
</div>
@endsection
