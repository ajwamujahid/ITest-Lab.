<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
        
    }
    protected $fillable = [
        'invoice_number',
        'branch_id',
        'amount',
        // Add any other columns you want to allow for mass assignment
    ];
//     public function testRequest()
// {
//     return $this->belongsTo(TestRequest::class);
// }
// Invoice.php
public function testRequest()
{
    return $this->hasOne(TestRequest::class);
}

    use HasFactory;
    
}
