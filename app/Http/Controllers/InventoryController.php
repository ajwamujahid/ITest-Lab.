<?php

namespace App\Http\Controllers;
use App\Models\InventoryItem;
use App\Models\InventoryCategory;
use App\Models\LowStockReport;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
   
public function create()
{
    $categories = InventoryCategory::all();
    $branches = Branch::all();
    return view('inventory.create', compact('categories', 'branches'));
}

public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'sku' => 'required|string|unique:inventory_items,sku',
        'category_id' => 'required|exists:inventory_categories,id', // ✅ fixed table
        'quantity' => 'required|integer|min:1',
        'unit' => 'required|string',
        'branch_id' => 'required|exists:branches,id',
        'expiry_date' => 'nullable|date',
        'supplier' => 'nullable|string',
    ]);

    InventoryItem::create($request->all());

    return redirect()->back()->with('success', 'Item added successfully!');
}
public function index(Request $request)
{
    $query = InventoryItem::with(['category', 'branch']);

    if ($request->category) {
        $query->where('category_id', $request->category);
    }

    $items = $query->get();

   $categories = InventoryCategory::all(); // ✅ fixed
    $branches = Branch::all();

    return view('inventory.inventory-items', compact('items', 'categories', 'branches'));
}
public function report()
    {
        $categories = InventoryCategory::all();
        $branches = Branch::all();

        return view('inventory.reports', compact('categories', 'branches'));
    }

    public function generate(Request $request)
    {
        $categories = InventoryCategory::all(); // ✅ Fix: define before compact()
        $branches = Branch::all();              // ✅ Fix: define before compact()
    
        $reportType = $request->input('report_type');
        $categoryId = $request->input('category_id');
        $branchId = $request->input('branch_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $query = InventoryItem::query();
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }
    
        switch ($reportType) {
            case 'stock_summary':
                $items = $query->get();
                break;
    
            case 'low_stock':
                $lowStockThreshold = 10;
                $items = $query->where('quantity', '<', $lowStockThreshold)->get();
                break;
    
            case 'expired_items':
                $today = \Carbon\Carbon::today(); // ✅ Add `use Carbon\Carbon;` if needed
                $items = $query->whereDate('expiry_date', '<=', $today)->get();
                break;
    
            default:
                $items = collect(); // Empty collection
                break;
        }
    
        return view('inventory.reports', compact(
            'items', 'categories', 'branches',
            'reportType', 'categoryId', 'branchId', 'startDate', 'endDate'
        ));
    }
    public function stockLevels(Request $request)
{
    $categories = InventoryCategory::all();
    $branches = Branch::all();

    $query = InventoryItem::with('category', 'branch');

    if ($request->branch_id) {
        $query->where('branch_id', $request->branch_id);
    }

    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    $items = $query->get();

    return view('inventory.stock-levels', compact('items', 'categories', 'branches'));
}

public function lowStockReports()
{
    // Fetch all low stock reports with related item and branch
    $reports = LowStockReport::with(['item', 'branch'])
                ->orderBy('created_at', 'desc')
                ->get();

    return view('inventory.low-stock-reports', compact('reports'));
}

public function updateLowStockReportStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,rejected',
    ]);

    $report = LowStockReport::findOrFail($id);
    $report->status = $request->status;
    $report->save();

    return redirect()->back()->with('success', 'Report status updated successfully!');
}

}
