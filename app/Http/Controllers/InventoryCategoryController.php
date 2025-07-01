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
    public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('csv_file');
    $data = array_map('str_getcsv', file($file));

    foreach ($data as $index => $row) {
        if ($index === 0) continue; // skip header row

        $name = trim($row[0]);

        if (!empty($name)) {
            InventoryCategory::firstOrCreate(['name' => $name]);
        }
    }

    return back()->with('success', 'Categories imported successfully from CSV!');
}

}
