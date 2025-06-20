<?php
// app/Http/Controllers/BranchInventoryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;

class BranchInventoryController extends Controller
{
    public function viewItems($branch_id = null)
    {
        if ($branch_id) {
            $items = InventoryItem::where('branch_id', $branch_id)
                                  ->with('category', 'branch')
                                  ->paginate(15);
        } else {
            $items = InventoryItem::with('category', 'branch')->paginate(15);
        }
    
        return view('branchadmin.inventory.view_items', compact('items', 'branch_id'));
    }
    

}
