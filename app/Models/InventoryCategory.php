<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $fillable = ['name'];
    protected $table = 'inventory_categories';

    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'category_id');
    }
}
