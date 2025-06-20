<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\RiderVisit;


class PatientController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {
        return view('patients.register');
    }

    // Handle patient registration
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:patients,email',
            'password'  => 'required|confirmed|min:6',
            'dob'       => 'required|date',
           'gender' => 'required|in:Male,Female,Other',

            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
        ]);

        $patient = Patient::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'dob'       => $request->dob,
            'gender'    => $request->gender,
            'phone'     => $request->phone,
            'address'   => $request->address,
            // 'role'      => 'patient',
        ]);

        return redirect()->route('patient.login.form')->with('success', 'Registered successfully! Please login.');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('patients.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('patient')->attempt($credentials)) {
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

   public function dashboard()
{
    $patient = Auth::guard('patient')->user();

    // ❌ GHALAT: with(['tests'])
    // ✅ Sahi: with(['testRequest.tests'])
    $visits = RiderVisit::with(['rider', 'testRequest.tests'])
        ->where('patient_id', auth()->id())
        ->latest()
        ->get();

    return view('patients.dashboard', compact('patient', 'visits'));
}


    

    // Logout
    public function logout()
    {
        Auth::guard('patient')->logout();
        return redirect()->route('patient.login.form')->with('status', 'Logged out successfully!');
    }
}
