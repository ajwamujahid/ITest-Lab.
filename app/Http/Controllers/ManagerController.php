<?php
namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Manager;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    public function create()
    {
        $branches = Branch::select('id', 'name')->get();
        return view('branchadmin.create_manager', compact('branches'));
    }
   
public function store(Request $request)
{
    $request->validate([
        'role' => 'required|in:manager,branch_admin',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:managers,email|unique:branch_admins,email',
        'password' => 'required|min:6|confirmed',
        'phone' => 'required',
        'branch_id' => 'required|exists:branches,id',
        // add other validations...
    ]);

    $data = $request->except('photo', 'password', 'password_confirmation');
    $data['password'] = bcrypt($request->password);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        $filename = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/users'), $filename);
        $data['photo'] = $filename;
    }

    if ($request->role == 'manager') {
        Manager::create($data);
    } else {
        BranchAdmin::create($data);
    }

    return back()->with('success', 'User added successfully!');
}



    public function toggleStatus($id)
    {
        $manager = Manager::findOrFail($id); // Make sure you use Manager, not Employee
        $manager->status = $manager->status === 'active' ? 'inactive' : 'active';
        $manager->save();
    
        return back()->with('success', 'Status updated successfully.');
    }
    
  
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:managers,email',
    //         'phone' => 'required|string|max:20',
    //         'cnic' => 'required|string|max:20|unique:managers,cnic',
    //         'dob' => 'required|date',
    //         'gender' => 'required|in:Male,Female,Other',
    //         'address' => 'nullable|string',
    //         'qualification' => 'nullable|string|max:255',
    //         'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'password' => 'required|min:6|confirmed',
    //         'branch_id' => 'required|exists:branches,id', // ✅ validate it
    //     ]);
    
    //     if ($request->hasFile('photo')) {
    //         $path = $request->file('photo')->store('public/manager_photos');
    //         $validated['photo'] = basename($path);
    //     }
    
    //     $validated['password'] = Hash::make($validated['password']);
    //     $validated['role'] = 'Manager'; // default role
    
    //     Manager::create($validated);
    
    //     return redirect()->back()->with('success', 'Manager created successfully!');
    // }
    

}
