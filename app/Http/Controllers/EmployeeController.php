<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee; 
use App\Models\Branch;
use App\Models\Manager;
use App\Models\Role;



class EmployeeController extends Controller
{
  
    
    public function filter(Request $request)
    {
        $branches = \App\Models\Branch::pluck('name', 'id')->toArray();

        $employees = Manager::with('branch');
    
        // ✅ filter directly by exact role from dropdown
        if ($request->filled('role')) {
            $employees->where('role', $request->role);
        }
    
        if ($request->filled('branch_id')) {
            $employees->where('branch_id', $request->branch_id);
        }
    
        $employees = $employees->get();
    
        return view('employees.filter', compact('branches', 'employees'));
    }
    

    
}
