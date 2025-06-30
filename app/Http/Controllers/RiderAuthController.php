<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Rider;

class RiderAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('rider.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'name'     => 'required|string',
            'password' => 'required|string',
        ]);

        $rider = Rider::where('email', $request->email)
        ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
        ->where('status', 'active') // ✅ Correct string match
        ->first();
    
        if ($rider && Hash::check($request->password, $rider->password)) {
            Auth::guard('rider')->login($rider);
            return redirect()->route('rider.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid login credentials or inactive account.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('rider')->logout(); // Or just Auth::logout(); if no custom guard
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('rider.login');
    }
    public function dashboard()
    {
        $rider = auth('rider')->user();
    
        // Mark all unread reviews as read
        \App\Models\RiderReview::where('rider_id', $rider->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
    
        return view('rider.dashboard');
    }
    public function markAlertSeen()
{
    $rider = auth('rider')->user();

    $rider->new_review_alert = false;
    $rider->save();

    return redirect()->back()->with('success', 'Alert dismissed.');
}

    
}
