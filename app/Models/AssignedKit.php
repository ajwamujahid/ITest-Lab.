<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedKit extends Model
{
    protected $table = 'assigned_kits'; // Explicit table name

    protected $fillable = [
        'rider_id',
        'inventory_item_id',
        'quantity_assigned',
        'status',
        'assigned_at',
    ];
    protected $casts = [
        'assigned_at' => 'datetime',
    ];
    
    // Relationships (optional but useful 👇)

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
    
    
}
