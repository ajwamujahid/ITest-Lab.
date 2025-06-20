<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Branch;
use App\Models\Role;
use App\Models\Department;

class EmployeeReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Manager::with(['branch', 'department']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('department')) {
            $managerIds = Department::where('id', $request->department)->pluck('manager_id');
            $query->whereIn('id', $managerIds);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $managers = $query->paginate(10);

        $branches = Branch::all();

        $roles = Role::pluck('name', 'name'); // Because roles are stored as string in Manager
        $departments = Department::pluck('name', 'id');

        return view('employees.employees-reports', compact('managers', 'branches', 'roles', 'departments'));
    }

    public function export(Request $request)
    {
        $managers = Manager::with(['branch', 'department'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="manager_report.csv"',
        ];

        $callback = function () use ($managers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Branch', 'Department', 'Joining Date']);

            foreach ($managers as $manager) {
                fputcsv($file, [
                    $manager->id,
                    $manager->name,
                    $manager->email,
                    $manager->role,
                    $manager->branch->name ?? 'N/A',
                    $manager->department->name ?? 'N/A',
                    $manager->created_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
