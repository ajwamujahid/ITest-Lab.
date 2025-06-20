<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Manager;
use App\Models\BranchAdmin;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeProfileController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::all();
        $roles = ['Manager', 'Branch Admin', 'Employee'];

        $results = [];

        // Fetch Managers
        if (!$request->role || $request->role === 'Manager') {
            $managers = Manager::with('branch')
                ->when($request->branch_id, fn($q) => $q->where('branch_id', $request->branch_id))
                ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->get()
                ->map(function ($item) {
                    $item->user_type = 'Manager';
                    return $item;
                });
            $results = array_merge($results, $managers->all());
        }

        // Fetch Branch Admins
        if (!$request->role || $request->role === 'Branch Admin') {
            $admins = BranchAdmin::with('branch')
                ->when($request->branch_id, fn($q) => $q->where('branch_id', $request->branch_id))
                ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->get()
                ->map(function ($item) {
                    $item->user_type = 'Branch Admin';
                    return $item;
                });
            $results = array_merge($results, $admins->all());
        }

        // Fetch Employees
        if (!$request->role || $request->role === 'Employee') {
            $employees = Employee::with('branch')
                ->when($request->branch_id, fn($q) => $q->where('branch_id', $request->branch_id))
                ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->get()
                ->map(function ($item) {
                    $item->user_type = 'Employee';
                    return $item;
                });
            $results = array_merge($results, $employees->all());
        }

        // Sort by creation date DESC
        usort($results, fn($a, $b) => strtotime($b->created_at) <=> strtotime($a->created_at));

        // Manual pagination
        $page = $request->input('page', 1);
        $perPage = 10;
        $paginated = new LengthAwarePaginator(
            array_slice($results, ($page - 1) * $perPage, $perPage),
            count($results),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('employee-profiles.index', [
            'employees' => $paginated,
            'branches' => $branches,
            'roles' => $roles,
        ]);
    }

    public function show($id, Request $request)
    {
        $type = $request->get('type');
    
        $user = match ($type) {
            'Manager' => Manager::with('branch')->findOrFail($id),
            'Branch Admin' => BranchAdmin::with('branch')->findOrFail($id),
            'Employee' => Employee::with('branch')->findOrFail($id),
            default => abort(404),
        };
    
        return view('employee-profiles.show', [
            'user' => $user,
            'user_type' => $type,
        ]);
    }
    
}
