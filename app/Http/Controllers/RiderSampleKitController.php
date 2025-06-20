<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiderSampleKitController extends Controller
{
    public function index()
    {
        $riderId = Auth::guard('rider')->id();

        $kits = DB::table('assigned_kits')
        ->join('inventory_items', 'assigned_kits.inventory_item_id', '=', 'inventory_items.id')
        ->leftJoin('rider_sample_kits', function($join) use ($riderId) {
            $join->on('assigned_kits.inventory_item_id', '=', 'rider_sample_kits.inventory_item_id')
                 ->where('rider_sample_kits.rider_id', '=', $riderId);
        })
        ->select(
            'assigned_kits.id as assigned_id',
            'assigned_kits.inventory_item_id',
            'assigned_kits.quantity_assigned', // 🆕 Added this line
            'inventory_items.item_name',
            'inventory_items.quantity',
            'rider_sample_kits.status as kit_status'
        )
        ->where('assigned_kits.rider_id', $riderId)
        ->get();
    

        return view('rider.sample_kits.index', compact('kits'));
    }

    public function update(Request $request, $assignedKitId)
    {
        $request->validate([
            'status' => 'required|in:used,unused',
        ]);

        $assignedKit = DB::table('assigned_kits')->where('id', $assignedKitId)->first();

        if (!$assignedKit) {
            return back()->withErrors('Assigned kit not found.');
        }

        $riderId = Auth::guard('rider')->id();

        // Check if already exists, then update, otherwise insert
        $existing = DB::table('rider_sample_kits')
            ->where('rider_id', $riderId)
            ->where('inventory_item_id', $assignedKit->inventory_item_id)
            ->first();

        if ($existing) {
            DB::table('rider_sample_kits')
                ->where('id', $existing->id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('rider_sample_kits')->insert([
                'rider_id' => $riderId,
                'inventory_item_id' => $assignedKit->inventory_item_id,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Kit status updated.');
    }
}
