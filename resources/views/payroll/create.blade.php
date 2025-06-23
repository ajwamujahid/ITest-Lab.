@extends('layouts.master')

@section('title', 'Add Payroll')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <h3 class="text-primary fw-bold mb-4 text-center">Add Payroll</h3>

                    {{-- Success Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    {{-- Payroll Form --}}
                    <form action="{{ route('payroll.store') }}" method="POST">
                        @csrf

                        {{-- Select Employee --}}
                        <div class="mb-3">
                            <label for="employee_id" class="form-label fw-semibold">Select Employee</label>
                            <select id="employee_id" name="employee_id" class="form-select shadow-sm" required>
                                <option value="">-- Select Employee --</option>
                                @foreach ($allEmployees as $emp)
                                    <option value="{{ $emp->id }}" data-type="{{ $emp->type }}">
                                        {{ ucfirst($emp->type) }} - {{ $emp->name }} 
                                        (Branch: {{ $emp->branch->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Hidden Employee Type --}}
                        <input type="hidden" id="employee_type" name="employee_type" required>

                        {{-- Basic Salary --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Basic Salary</label>
                            <input type="number" step="0.01" name="basic_salary" class="form-control shadow-sm" required>
                        </div>

                        {{-- Allowances --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Allowances</label>
                            <input type="number" step="0.01" name="allowances" class="form-control shadow-sm">
                        </div>

                        {{-- Deductions --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deductions</label>
                            <input type="number" step="0.01" name="deductions" class="form-control shadow-sm">
                        </div>

                        {{-- Month & Year --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Month</label>
                                <select name="month" class="form-select shadow-sm" required>
                                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Year</label>
                                <input type="number" name="year" class="form-control shadow-sm" value="{{ now()->year }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks (optional)</label>
                            <textarea name="remarks" class="form-control shadow-sm"></textarea>
                        </div>
                        
                        {{-- Submit Button --}}
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                 Submit Payroll
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS to capture selected employee type --}}
<script>
    document.getElementById('employee_id').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('employee_type').value = selectedOption.getAttribute('data-type');
    });
</script>
@endsection
