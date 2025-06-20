<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
class ComplaintController extends Controller
{
    // public function create()
    // {
    //     // Pass branch options (you can fetch from DB or hardcode)
    //     $branches = ['Branch A', 'Branch B', 'Branch C'];
    //     return view('complaints.create', compact('branches'));
    // }
    public function create()
    {
        $branches = Branch::pluck('name'); // Pulls branch names from DB
        return view('complaints.create', compact('branches')); // Passes to view
    }
    
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'complaint_text' => 'required|string',
            'target_role' => 'required|in:super_admin,admin',
            'branch' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints_attachments', 'public');
        }

        Complaint::create([
            'patient_name' => $request->patient_name,
            'complaint_text' => $request->complaint_text,
            'target_role' => $request->target_role,
            'branch' => $request->branch,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->back()->with('success', 'Complaint lodged successfully.');
    }
    public function viewComplaints()
    {
        // Just get complaints where target_role is 'super_admin'
        $complaints = Complaint::where('target_role', 'super_admin')->get();
    
        // Pass 'super_admin' as the role to the view (optional)
        $role = 'super_admin';
    
        return view('complaints.view', compact('complaints', 'role'));
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,in-progress,resolved,rejected',
    ]);

    $complaint = Complaint::findOrFail($id);
    $complaint->status = $request->status;
    $complaint->save();

    return redirect()->back()->with('success', 'Complaint status updated successfully!');
}
public function myComplaints()
{
    // Assuming your complaints table has a 'user_id' field that links to the patient
    $userId = Auth::id();

    // Get complaints only for the logged-in user/patient
    $complaints = Complaint::where('id', $userId)->orderBy('created_at', 'desc')->get();

    return view('complaints.patient_complaints', compact('complaints'));
}

}
