<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\InventoryItem;
use App\Models\RiderSampleKit;
use App\Models\AssignedKit; 
class KitAssignmentController extends Controller
{
    public function create()
    {
        $riders = Rider::select('id', 'name')->get();
        $kits = InventoryItem::where('quantity', '>', 0)->get();

        return view('manager.kits.assign', compact('riders', 'kits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rider_id' => 'required|exists:riders,id',
            'kit_ids' => 'required|array',
            'kit_ids.*' => 'exists:inventory_items,id',
            'quantities' => 'required|array',
        ]);
    
        foreach ($request->kit_ids as $kitId) {
            $assignedQty = $request->quantities[$kitId] ?? 0;
    
            // Optional: validate that quantity is not more than available
            $item = InventoryItem::findOrFail($kitId);
            if ($assignedQty < 1 || $assignedQty > $item->quantity) {
                return back()->with('error', "Invalid quantity for kit ID $kitId.");
            }
    
            // Insert into assigned_kits
            DB::table('assigned_kits')->insert([
                'rider_id' => $request->rider_id,
                'inventory_item_id' => $kitId,
                'quantity_assigned' => $assignedQty,
               // 'status' => 'unused', // Optional if your table has this
                'assigned_at' => now(),
            ]);
    
            // Decrease quantity in inventory_items
            $item->decrement('quantity', $assignedQty);
        }
    
        return redirect()->back()->with('success', 'Kits successfully assigned to rider.');
    }
    public function viewAssignedKits()
{
    $assignedKits = AssignedKit::with(['rider', 'inventoryItem'])->get();


    return view('manager.kits.assigned_kits', compact('assignedKits'));
}
}
