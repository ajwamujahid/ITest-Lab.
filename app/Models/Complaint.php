<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Complaint extends Model
{
    protected $fillable = [
        'patient_name', 'complaint_text', 'target_role', 'branch', 'attachment',
    ];
}
