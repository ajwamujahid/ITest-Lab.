<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch', 'id'); // or use 'branch_id' if it exists
    }
    
}
