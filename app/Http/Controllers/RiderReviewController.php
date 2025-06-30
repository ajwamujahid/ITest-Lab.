<?php

namespace App\Http\Controllers;
use App\Models\RiderReview;
use App\Jobs\NotifyRiderReviewJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RiderReviewController extends Controller
{
    
    public function index()
    {
        $riderId = Auth::guard('rider')->id(); // more precise
        $reviews = RiderReview::with('patient')
            ->where('rider_id', $riderId)
            ->orderByDesc('created_at')
            ->get();

    
        return view('rider.reviews.index', compact('reviews'));
    }
    

  
    public function store(Request $request)
    {
        $request->validate([
            'rider_id' => 'required|exists:riders,id',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:500',
        ]);
    
        $review = RiderReview::create([
            'patient_id' => Auth::guard('patient')->id(),
            'rider_id' => $request->rider_id,
            'rating' => $request->rating,
            'message' => $request->message,
        ]);
    
        NotifyRiderReviewJob::dispatch($review); // ✅ Must be here!
    
        return redirect()->route('patient.dashboard')->with('success', 'Thank you for your review!');
    }
    

}
