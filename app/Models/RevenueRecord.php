<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueRecord extends Model
{
    protected $fillable = [
        'patient_name',
        'test_name',
        'test_date',
        'amount_charged',
        'payment_status',
        'branch',
    ];

    protected $dates = ['test_date'];
}
