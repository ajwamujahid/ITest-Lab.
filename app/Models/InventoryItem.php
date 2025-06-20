<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name', 'sku', 'category_id', 'quantity',
        'unit', 'branch_id', 'expiry_date', 'supplier'
    ];
    protected $casts = [
        'expiry_date' => 'date',
    ];
    
    // InventoryItem.php
public function category()
{
    return $this->belongsTo(InventoryCategory::class, 'category_id');
}

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


}
