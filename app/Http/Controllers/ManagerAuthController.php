<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('manager.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('manager')->attempt($credentials)) {
            $manager = Auth::guard('manager')->user();
    
            if ($manager->status !== 'active') {
                Auth::guard('manager')->logout();
                return back()->withErrors(['email' => 'Your account is inactive.'])->withInput();
            }
    
            return redirect()->route('manager.manager-dashboard');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    
    public function dashboard()
    {
        $manager = Auth::guard('manager')->user();
        return view('manager.manager-dashboard', compact('manager'));
    }

    public function logout(Request $request)
    {
        Auth::guard('manager')->logout();
        return redirect()->route('manager.login');
    }
}
