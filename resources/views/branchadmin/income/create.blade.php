@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Add Income</h2>
    <form method="POST" action="{{ route('income.store') }}">
        @csrf
    
        <input type="hidden" name="branch_id" value="1"> {{-- Change this dynamically if needed --}}
    
        <div class="form-group">
            <label>Source</label>
            <input type="text" name="source" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Amount (Rs.)</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Income Date</label>
            <input type="date" name="income_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Note</label>
            <textarea name="note" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Income</button>
    </form>
    
</div>
@endsection
