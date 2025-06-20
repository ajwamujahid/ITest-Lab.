<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use Illuminate\Http\Request;

class PerformanceReviewController extends Controller
{
    public function index()
{
    $branches = Branch::all();
    $roles = ['Manager', 'Branch Admin', 'Employee']; // or fetch dynamically if needed
    return view('performance-reviews.index', compact('branches', 'roles'));
}

public function getData(Request $request)
{
    $query = PerformanceReview::with(['employee', 'reviewer', 'branch']);

    if ($request->branch_id) {
        $query->where('branch_id', $request->branch_id);
    }

    if ($request->role) {
        $query->whereHas('employee', fn($q) => $q->where('role', $request->role));
    }

    if ($request->from && $request->to) {
        $query->whereBetween('created_at', [$request->from, $request->to]);
    }

    return DataTables::of($query)
        ->addColumn('employee_name', fn($row) => $row->employee->name)
        ->addColumn('reviewer_name', fn($row) => $row->reviewer->name)
        ->addColumn('actions', fn($row) => '<a href="#" class="btn btn-sm btn-info view-review" data-id="'.$row->id.'">View</a>')
        ->rawColumns(['actions'])
        ->make(true);
}

public function show($id)
{
    $review = PerformanceReview::with(['employee', 'reviewer', 'branch'])->findOrFail($id);
    return response()->json($review);
}

}
