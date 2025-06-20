<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchInventoryReport;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
class BranchInventoryReportController extends Controller
{
    public function create()
    {
        $categories = InventoryCategory::all();
        return view('branchadmin.create_report', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'item_ids' => 'required|array',
            'category_id' => 'nullable|exists:inventory_categories,id',
            'report_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        BranchInventoryReport::create([
            'branch_admin_id' => auth()->id(),
            'report_type' => $request->report_type,
            'category_id' => $request->category_id,
            'report_date' => $request->report_date ?? now(),
            'item_ids' => json_encode($request->item_ids),
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully!');
    }
    
        public function getItemsByCategory(Request $request)
        {
            $categoryId = $request->get('category_id');
    
            if (!$categoryId) {
                return response()->json([]);
            }
    
            $items = InventoryItem::where('category_id', $categoryId)->get(['id', 'item_name', 'sku']);
    
            return response()->json($items);
        }
    
}
