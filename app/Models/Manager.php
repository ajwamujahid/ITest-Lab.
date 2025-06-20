<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'managers';

    protected $fillable = [
        'name', 'email', 'phone', 'cnic', 'dob', 'gender', 'address',
        'qualification', 'photo', 'password', 'role_id', 'department_id', 'branch_id'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function department()
{
    return $this->hasOne(Department::class, 'manager_id', 'id');
}

}
