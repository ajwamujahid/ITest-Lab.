<?php
namespace App\Http\Controllers;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\LowStockReport;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Auth;
class LowStockReportController extends Controller
{


public function create()
{
    $items = InventoryItem::all();
    $branches = Branch::all(); // 👈 Add this
    return view('branchadmin.low_stock_form', compact('items', 'branches'));
}
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:inventory_items,id',
            'quantity_reported' => 'required|integer|min:1',
            'branch_id' => 'required|exists:branches,id',
        ]);
    
        LowStockReport::create([
            'branch_id' => $request->branch_id,
            'item_id' => $request->item_id,
            'quantity_reported' => $request->quantity_reported,
            'status' => 'pending',
        ]);
    
        return redirect()->back()->with('success', 'Low stock report submitted successfully!');
    }
    
    public function index()
    {
        // Show only this branch's reports (optional: if user isn't authenticated, show all)
        $reports = LowStockReport::with(['item', 'branch'])->get();
    
        return view('branchadmin.my_low_stock_reports', compact('reports'));
    }
    
  

}
