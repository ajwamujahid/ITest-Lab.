<?php

namespace App\Models;
use App\Models\Branch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'email',
        'role',
        'branch_id',
        'status',
    ];

    public function role()
{
    return $this->belongsTo(Role::class);
}

public function branch()
{
    return $this->belongsTo(Branch::class);
}

public function department()
{
    return $this->belongsTo(Department::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}



}
