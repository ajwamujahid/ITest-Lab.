<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'source',
        'amount',
        'income_date',
        'note',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
