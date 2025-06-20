<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryCategory; // ✅ correct

class InventoryCategoryController extends Controller
{
    public function index()
    {
        $categories = InventoryCategory::all(); // ✅ correct
        return view('inventory.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:inventory_categories,name',
        ]);

        InventoryCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category created!');
    }

    public function destroy($id)
    {
        InventoryCategory::destroy($id);
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
