<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
   
    
        protected $fillable = [
            'employee_id',
            'employee_type',
            'basic_salary',
            'allowances',
            'deductions',
            'total_salary',
            'month',
            'year',
        ];
    
    

    // public function getEmployeeName()
    // {
    //     switch ($this->employee_type) {
    //         case 'employee':
    //             $emp = \App\Models\Employee::find($this->employee_id);
    //             return $emp ? $emp->name : 'N/A';

    //         case 'manager':
    //             $mgr = \App\Models\Manager::find($this->employee_id);
    //             return $mgr ? $mgr->name : 'N/A';

    //         case 'branch_admin':
    //             $ba = \App\Models\BranchAdmin::find($this->employee_id);
    //             return $ba ? $ba->name : 'N/A';

    //         default:
    //             return 'N/A';
    //     }
    // }
    public function getEmployeeName()
{
    return match($this->employee_type) {
        'employee' => \App\Models\Employee::find($this->employee_id)?->name ?? 'Unknown',
        'manager' => \App\Models\Manager::find($this->employee_id)?->name ?? 'Unknown',
        'branch_admin' => \App\Models\BranchAdmin::find($this->employee_id)?->name ?? 'Unknown',
        default => 'Unknown'
    };
}

}
