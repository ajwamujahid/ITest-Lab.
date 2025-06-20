<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rider extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'phone',
        'email',
        'photo',
        'vehicle_type',
        'vehicle_number',
        'cnic',
        'address',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
    public function reviews()
    {
        return $this->hasMany(RiderReview::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
