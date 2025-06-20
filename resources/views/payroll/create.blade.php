@extends('layouts.master') <!-- or your layout file -->

@section('content')
<div class="container">
    <h2>Add Payroll</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('payroll.store') }}" method="POST">
        @csrf

        <!-- Select Employee -->
        <div class="form-group">
            <label for="employee_id">Select Employee</label>
            <select id="employee_id" name="employee_id" class="form-control" required>
                <option value="">-- Select Employee --</option>
                @foreach ($allEmployees as $emp)
                <option value="{{ $emp->id }}" data-type="{{ $emp->type }}">
                    {{ ucfirst($emp->type) }} - {{ $emp->name }} (Branch: {{ $emp->branch ? $emp->branch->name : 'N/A' }})
                </option>
                
            @endforeach
            
            </select>
        </div>

        <!-- Hidden Input to Store Type -->
        <input type="hidden" id="employee_type" name="employee_type" required>

        <!-- Basic Salary -->
        <div class="form-group mt-2">
            <label for="basic_salary">Basic Salary</label>
            <input type="number" step="0.01" name="basic_salary" class="form-control" required>
        </div>

        <!-- Allowances -->
        <div class="form-group mt-2">
            <label for="allowances">Allowances</label>
            <input type="number" step="0.01" name="allowances" class="form-control">
        </div>

        <!-- Deductions -->
        <div class="form-group mt-2">
            <label for="deductions">Deductions</label>
            <input type="number" step="0.01" name="deductions" class="form-control">
        </div>

        <!-- Month & Year -->
        <div class="form-row mt-2">
            <div class="col">
                <label for="month">Month</label>
                <select name="month" class="form-control" required>
                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="year">Year</label>
                <input type="number" name="year" class="form-control" value="{{ now()->year }}" required>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Submit Payroll</button>
        </div>
    </form>
</div>

<!-- JS for Employee Type -->
<script>
    document.getElementById('employee_id').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('employee_type').value = selectedOption.getAttribute('data-type');
    });
</script>
@endsection
