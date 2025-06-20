<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\RiderReview; // agar table hai
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use Illuminate\Support\Facades\Hash;

class RiderController extends Controller
{
    public function index()
    {
        $branchId = auth()->user()->branch_id;
        $riders = Rider::where('branch_id', $branchId)->get();
    
        return view('branchadmin.riders.index', compact('riders'));
    }
    
    
    public function create()
    {
        return view('branchadmin.riders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:riders,email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'required|string',
            'cnic' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $rider = new Rider();
        $rider->branch_id = auth()->user()->branch_id;
        $rider->name = $request->name;
        $rider->phone = $request->phone;
        $rider->email = $request->email;
        $rider->vehicle_type = $request->vehicle_type;
        $rider->vehicle_number = $request->vehicle_number;
        $rider->cnic = $request->cnic;
        $rider->address = $request->address;
        $rider->status = $request->status;
        $rider->password = Hash::make($request->password);

        // Upload photo if provided
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('riders', 'public');
            $rider->photo = $photoPath;
        }

        $rider->save();

        return redirect()->back()->with('success', 'Rider registered successfully!');
    }
    public function show($id)
{
    $rider = Rider::findOrFail($id);

    // Us rider ke appointments
    $appointments = \App\Models\Appointment::where('rider_id', $id)->get();

    // Us rider ke reviews (agar separate table banaya hai)
    $reviews = \App\Models\RiderReview::where('rider_id', $id)->get();

    return view('branchadmin.riders.show', compact('rider', 'appointments', 'reviews'));
}
public function report($id)
{
    $branchId = auth()->user()->branch_id;

    $rider = Rider::where('branch_id', $branchId)->findOrFail($id);

    // Appointments assigned to this rider
    $appointments = Appointment::where('rider_id', $rider->id)->get();

    // Reviews for this rider (assuming you have a 'rider_reviews' table)
    $reviews = RiderReview::where('rider_id', $rider->id)->get();

    return view('branchadmin.riders.report', compact('rider', 'appointments', 'reviews'));
}

}
