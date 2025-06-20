@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Payroll Records</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Branch</th>
                <th>Basic Salary</th>
                <th>Allowances</th>
                <th>Deductions</th>
                <th>Total Salary</th>
                <th>Month</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->getEmployeeName() }}</td>
                    <td>{{ ucfirst($payroll->employee_type) }}</td>
                    <td>
                        @php
                            $branch_id = match($payroll->employee_type) {
                                'employee' => \App\Models\Employee::find($payroll->employee_id)?->branch_id,
                                'manager' => \App\Models\Manager::find($payroll->employee_id)?->branch_id,
                                'branch_admin' => \App\Models\BranchAdmin::find($payroll->employee_id)?->branch_id,
                                default => null,
                            };
                            $branchName = $branch_id ? \App\Models\Branch::find($branch_id)?->name : 'N/A';
                        @endphp
                        {{ $branchName }}
                    </td>
                    <td>{{ number_format($payroll->basic_salary, 2) }}</td>
                    <td>{{ number_format($payroll->allowances, 2) }}</td>
                    <td>{{ number_format($payroll->deductions, 2) }}</td>
                    <td>{{ number_format($payroll->total_salary, 2) }}</td>
                    <td>{{ $payroll->month }}</td>
                    <td>{{ $payroll->year }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No payroll records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
