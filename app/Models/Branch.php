<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'location',
        'zip_code',
        'latitude',
        'longitude',
        'address',
        'city',
        'state',
        'country',
        'phone',
        'email',
        'status',
        'manager_name',
        'opening_time',
        'closing_time',
    ];
    
    public function invoices()
{
    return $this->hasMany(Invoice::class);
}

}
