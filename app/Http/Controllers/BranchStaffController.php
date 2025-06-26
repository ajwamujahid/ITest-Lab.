<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Department;

class BranchStaffController extends Controller
{
    public function index()
    {
        $branchId = session('branch_id', 2); // Set current branch

        // Get all managers of this branch
        $staff = Manager::where('branch_id', $branchId)->get();

        // Attach department names manually using manager_id mapping
        foreach ($staff as $manager) {
            $department = Department::where('manager_id', $manager->id)->first();
            $manager->department_name = $department->name ?? 'N/A';
        }

        return view('branchadmin.staff.index', compact('staff'));
    }
    public function toggleStatus($id)
{
    $manager = Manager::findOrFail($id);
    $manager->status = $manager->status === 'active' ? 'inactive' : 'active';
    $manager->save();

    return redirect()->back()->with('success', 'Staff status updated successfully.');
}

}
