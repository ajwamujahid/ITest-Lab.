<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ use this
use Illuminate\Notifications\Notifiable;

class BranchAdmin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'qualification',
        'address',
        'cnic',
        'branch_id',
        'gender',
        'age',
        'university',
        'joining_date',
        'profile_picture',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'joining_date' => 'date',
    ];
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

