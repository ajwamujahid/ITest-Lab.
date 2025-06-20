<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowStockReport extends Model
{
    protected $fillable = ['branch_id', 'item_id', 'quantity_reported', 'status'];

    public function item() {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
