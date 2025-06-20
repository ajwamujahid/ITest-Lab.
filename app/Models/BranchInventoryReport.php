<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchInventoryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_admin_id',
        'report_type',
        'category_id',
        'report_date',
        'item_ids',
        'notes',
    ];

    protected $casts = [
        'item_ids' => 'array',
        'report_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id');
    }

    public function branchAdmin()
    {
        return $this->belongsTo(BranchAdmin::class, 'branch_admin_id');
    }
}
