<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Manager; // <-- Import Manager model
use Illuminate\Http\Request;
use App\Models\Role;
class DepartmentController extends Controller
{
    // Show list of departments
    public function index()
    {
        $departments = Department::with('manager')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    // Show form to create new department
    public function create()
    {
        $managers = Manager::all(); // fetch from managers table
        $roles = Role::all(); // make sure this is added
 
        return view('departments.create', compact('managers','roles'));
    }

    // Store new department
    public function store(Request $request)
    {
        $data = $request->only(['name', 'description', 'manager_id']);
        Department::create($data);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load('manager', 'employees');
        return view('departments.show', compact('department'));
    }
    

    // Show form to edit department
    public function edit(Department $department)
    {
        $managers = Manager::all();  // fetch managers here too
        return view('departments.edit', compact('department', 'managers'));
    }

    // Update department
    public function update(Request $request, Department $department)
    {
        $data = $request->only(['name', 'description', 'manager_id']);
        $department->update($data);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    // Delete department
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
