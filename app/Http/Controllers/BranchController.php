<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Http;

class BranchController extends Controller
{
    // List all branches
    public function index()
    {
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $latitude = null;
        $longitude = null;
        $city = null;
        $state = null;
        $country = null;
        $zip_code = null;

        $response = Http::withHeaders([
            'User-Agent' => 'LabSystem/1.0 (mujahidajwa1207@gamil.com)',
            'Accept-Language' => 'en', // 🔥 Force English output
        ])->get('https://nominatim.openstreetmap.org/search', [
            'format' => 'json',
            'q'      => $request->location,
            'addressdetails' => 1,
            'limit'  => 1,
        ]);
        

        if ($response->ok() && isset($response[0])) {
            $result = $response[0];
            $latitude  = $result['lat'] ?? null;
            $longitude = $result['lon'] ?? null;

            // 🏙 Address breakdown
            $address = $result['address'] ?? [];
            $city     = $address['city']     ?? $address['town'] ?? $address['village'] ?? null;
            $state    = $address['state']    ?? null;
            $country  = $address['country']  ?? null;
            $zip_code = $address['postcode'] ?? null;
        } else {
            \Log::error('Nominatim Error', $response->json());
            return back()->with('error', 'Could not find coordinates. Please enter a valid address.');
        }

        // 💾 Save branch
        Branch::create([
            'name'       => $request->name,
            'location'   => $request->location,
            'latitude'   => $latitude,
            'longitude'  => $longitude,
            'city'       => $city,
            'state'      => $state,
            'country'    => $country,
            'zip_code'   => $zip_code,
        ]);

        return back()->with('success', '✅ Branch saved with full location details!');
    }
}
