<?php

namespace App\Http\Controllers;
use App\Models\RiderReview;
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
    
}
