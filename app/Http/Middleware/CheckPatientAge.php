<?php
// app/Http/Middleware/CheckPatientAge.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon; // ✅ Carbon properly imported

class CheckPatientAge
{
    public function handle(Request $request, Closure $next)
    {
        $dob = $request->input('dob');

        if (!$dob) {
            return redirect()->back()->withErrors(['dob' => 'Date of birth is required.']);
        }

        try {
            $age = Carbon::parse($dob)->age;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['dob' => 'Invalid date format.']);
        }

        if ($age < 18) {
            return redirect()->back()->withErrors(['dob' => 'You must be at least 18 years old to register.']);
        }

        return $next($request);
    }
}
