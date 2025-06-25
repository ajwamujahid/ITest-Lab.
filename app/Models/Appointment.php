<?php

namespace App\Models;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'test_request_id',
        'patient_id',
        'branch_id',
        'rider_id',
        'test_type',
        'appointment_date',
        'status',
        'visit_status',
        'invoice_number',
        'amount',
        'invoice_url'
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
    return $this->belongsTo(\App\Models\TestRequest::class, 'test_request_id');
}

// public function testRequest()
// {
//     return $this->hasOne(\App\Models\TestRequest::class, 'patient_id', 'patient_id')->latestOfMany();
// }
public function branch()
{
    return $this->belongsTo(\App\Models\Branch::class);
}


}
