@extends('layouts.master')

@section('title', 'Payroll Records')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-primary fw-bold mb-0"> Payroll Records</h3>
                        <a href="{{ route('payroll.create') }}" class="btn btn-sm btn-primary shadow-sm px-4 py-2 rounded-3">
                             Add Payroll
                        </a>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Payroll Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
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
                                    @php
                                        $employee = match($payroll->employee_type) {
                                            'employee' => \App\Models\Employee::find($payroll->employee_id),
                                            'manager' => \App\Models\Manager::find($payroll->employee_id),
                                            'branch_admin' => \App\Models\BranchAdmin::find($payroll->employee_id),
                                            default => null,
                                        };

                                        $employeeName = $employee?->name ?? 'Unknown';
                                        $branchName = $employee && $employee->branch_id
                                            ? (\App\Models\Branch::find($employee->branch_id)?->name ?? 'N/A')
                                            : 'N/A';
                                    @endphp
                                    <tr class="text-center">
                                        <td class="fw-semibold">{{ $employeeName }}</td>
                                        <td>
                                            <span class="badge bg-secondary text-light px-3 py-1">{{ ucfirst($payroll->employee_type) }}</span>
                                        </td>
                                        <td>{{ $branchName }}</td>
                                        <td>Rs. {{ number_format($payroll->basic_salary, 2) }}</td>
                                        <td>
                                            <span class="text-success">+ Rs. {{ number_format($payroll->allowances, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-danger">− Rs. {{ number_format($payroll->deductions, 2) }}</span>
                                        </td>
                                        <td class="fw-bold text-primary">Rs. {{ number_format($payroll->total_salary, 2) }}</td>
                                        <td>{{ $payroll->month }}</td>
                                        <td>{{ $payroll->year }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No payroll records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Optional Pagination --}}
                    @if($payrolls instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-3">
                            {{ $payrolls->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
