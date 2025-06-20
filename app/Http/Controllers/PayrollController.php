<?php
namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\BranchAdmin;
use App\Http\Controllers\Controller;

class PayrollController extends Controller
{
    

    public function index()
    {
        $payrolls = Payroll::latest()->get();
    
        $payrolls = $payrolls->map(function($payroll) {
            if ($payroll->employee_type == 'employee') {
                $employee = Employee::find($payroll->employee_id);
            } elseif ($payroll->employee_type == 'manager') {
                $employee = Manager::find($payroll->employee_id);
            } elseif ($payroll->employee_type == 'branch_admin') {
                $employee = BranchAdmin::find($payroll->employee_id);
            } else {
                $employee = null;
            }
    
            return (object) [
                'id'             => $payroll->id,
                'employee_id'    => $payroll->employee_id,
                'employee_type'  => $payroll->employee_type,
                'basic_salary'   => $payroll->basic_salary,
                'allowances'     => $payroll->allowances,
                'deductions'     => $payroll->deductions,
                'total_salary'   => $payroll->total_salary,
                'month'          => $payroll->month,
                'year'           => $payroll->year,
                'employee_name'  => $employee ? $employee->name : 'N/A',
                'branch_name'    => $employee ? Branch::find($employee->branch_id)?->name : 'N/A',
            ];
        });
    
        return view('payroll.index', compact('payrolls'));
    }
    
    public function create()
    {
        $employees = Employee::with('branch')->get()->map(function ($e) {
            $e->type = 'employee';  // add a type property dynamically
            return $e;
        });
    
        $managers = Manager::with('branch')->get()->map(function ($m) {
            $m->type = 'manager';
            return $m;
        });
    
        $admins = BranchAdmin::with('branch')->get()->map(function ($a) {
            $a->type = 'branch_admin';
            return $a;
        });
    
        $allEmployees = $employees->merge($managers)->merge($admins);
    
        return view('payroll.create', compact('allEmployees'));
    }
    
}
