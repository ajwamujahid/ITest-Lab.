<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class BranchAdminTestController extends Controller
{
    public function pending()
    {
        $branchId = auth('branchadmin')->user()->branch_id;

        $appointments = Appointment::with('patient')
            ->where('branch_id', $branchId)
            ->where('status', 'scheduled')
            ->where('visit_status', 'pending') // Optional, if you want to use this too
            ->latest('appointment_date')
            ->paginate(20);

        return view('branchadmin.tests.pending', compact('appointments'));
    }

    public function completed()
    {
        $branchId = auth('branchadmin')->user()->branch_id;

        $appointments = Appointment::with('patient')
            ->where('branch_id', $branchId)
            ->where('status', 'completed')
            ->latest('appointment_date')
            ->paginate(20);

        return view('branchadmin.tests.completed', compact('appointments'));
    }

    public function all()
    {
        $branchId = auth('branchadmin')->user()->branch_id;

        $appointments = Appointment::with('patient')
            ->where('branch_id', $branchId)
            ->latest('appointment_date')
            ->paginate(20);

        return view('branchadmin.tests.all', compact('appointments'));
    }
}
