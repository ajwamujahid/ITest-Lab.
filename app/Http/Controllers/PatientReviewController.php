<?php
// app/Http/Controllers/PatientReviewController.php
namespace App\Http\Controllers;
use App\Jobs\NotifyRiderReviewJob;

use Illuminate\Http\Request;
use App\Models\RiderReview;
use Illuminate\Support\Facades\Auth;
use App\Models\Rider; // add this on top
class PatientReviewController extends Controller
{
   
    public function create($rider_id)
    {
        $rider = Rider::findOrFail($rider_id);
    
        // Get previous reviews by this patient for this rider
        $previousReviews = \App\Models\RiderReview::where('rider_id', $rider_id)
                            ->where('patient_id', Auth::guard('patient')->id())
                            ->latest()
                            ->get();
    
        return view('patients.reviews.create', compact('rider', 'previousReviews'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'rider_id' => 'required|exists:riders,id',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:500',
        ]);
    
        // Step 1: Create review
        $review = RiderReview::create([
            'patient_id' => Auth::guard('patient')->id(),
            'rider_id' => $request->rider_id,
            'rating' => $request->rating,
            'message' => $request->message,
        ]);
    
        // Step 2: Dispatch job (Background notification to rider)
        NotifyRiderReviewJob::dispatch($review);
    
        return redirect()->route('patient.dashboard')->with('success', 'Thank you for your review!');
    }
    
}
