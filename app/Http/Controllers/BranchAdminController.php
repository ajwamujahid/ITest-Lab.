<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\BranchAdmin;
use App\Models\TestRequest;

class BranchAdminController extends Controller
{
    public function create()
    {
        $branches = Branch::all(); // Show branches dropdown
        return view('branchadmin.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:branch_admins,email|max:255',
            'phone'           => 'required|string|max:20',
            'qualification'   => 'required|string|max:255',
            'address'         => 'nullable|string|max:500',
            'cnic'            => 'required|string|max:20',
            'branch_id'       => 'required|exists:branches,id',
            'gender'          => 'nullable|in:male,female,other',
            'age'             => 'nullable|integer|min:18',
            'university'      => 'nullable|string|max:255',
            'joining_date'    => 'nullable|date',
            'profile_picture' => 'nullable|image|max:2048',
            'password'        => 'required|string|min:6|confirmed',
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('admins', 'public');
            $validated['profile_picture'] = $path;
        }

        $validated['password'] = Hash::make($validated['password']);
        BranchAdmin::create($validated);

        return redirect()->back()->with('success', 'Branch Admin added successfully.');
    }

    public function index()
    {
        $branchAdmins = BranchAdmin::with('branch')->get();
        return view('branchadmin.index', compact('branchAdmins'));
    }

    public function showLoginForm()
    {
        return view('branchadmin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('branchadmin')->attempt($credentials)) {
            return redirect()->route('branchadmin.dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::guard('branchadmin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('branchadmin.login')->with('success', 'Logged out successfully');
    }

    public function dashboard()
    {
        return view('branchadmin.dashboard');
    }

    // ✅ Show all tests for this branch
    public function allTests()
    {
        $branchName = Auth::guard('branchadmin')->user()->branch->name;

        $tests = TestRequest::where('branch', $branchName)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('branchadmin.tests.all', compact('tests'));
    }

    // ✅ Show only pending tests
    public function pendingTests()
    {
        $branchName = Auth::guard('branchadmin')->user()->branch->name;

        $tests = TestRequest::where('branch', $branchName)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('branchadmin.tests.pending', compact('tests'));
    }

    // ✅ Show only completed tests
    public function completedTests()
    {
        $branchName = Auth::guard('branchadmin')->user()->branch->name;

        $tests = TestRequest::where('branch', $branchName)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('branchadmin.tests.completed', compact('tests'));
    }
}
