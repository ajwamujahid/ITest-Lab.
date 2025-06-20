<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model
{
    protected $fillable = [
        'amount',
        'description',
        'expense_date',
        'branch_id',
        'category',
    ];
    
  // Expense.php
public function branch()
{
    return $this->belongsTo(\App\Models\Branch::class);
}

}
