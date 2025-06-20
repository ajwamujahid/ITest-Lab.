<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');  // create this Blade view
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Assuming you have a guard called 'admin' or just default auth for admins
        if (Auth::attempt($credentials)) {
            // Successful login
            return redirect()->route('superadmindashboard');
        }

        // Login failed
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

public function superAdminDashboard()
{
    $user = Auth::user();

    if ($user->role !== 'super_admin') {
        abort(403, 'Unauthorized access');
    }

    $complaints = Complaint::where('target_role', 'super_admin')->get();

    return view('pages.superadmindashboard', compact('complaints'));
}

}
