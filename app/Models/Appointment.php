<?php

namespace App\Models;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'branch_id', 'rider_id', 'test_type',
        'amount', 'appointment_date', 'status', 'invoice_url',
        'visit_status' // 👈 include this if it's fillable
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];
    

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    
public function rider()
{
    return $this->belongsTo(Rider::class, 'rider_id');
}
public function testRequest()
{
    return $this->hasOne(\App\Models\TestRequest::class, 'patient_id', 'patient_id')->latestOfMany();
}
public function branch()
{
    return $this->belongsTo(\App\Models\Branch::class);
}


}
