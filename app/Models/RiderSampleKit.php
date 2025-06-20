<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiderSampleKit extends Model
{
    protected $fillable = ['rider_id', 'inventory_item_id', 'status'];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }
}
