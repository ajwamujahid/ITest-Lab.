<?php
namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Manager;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:managers,email',
            'phone' => 'required|string|max:20',
            'cnic' => 'required|string|max:20|unique:managers,cnic',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id', // ✅ validate it
        ]);
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/manager_photos');
            $validated['photo'] = basename($path);
        }
    
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'Manager'; // default role
    
        Manager::create($validated);
    
        return redirect()->back()->with('success', 'Manager created successfully!');
    }
    

}
