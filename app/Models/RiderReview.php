<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'rider_id',
        'rating',
        'message',
    ];

    // Relationships

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id', 'id');
    }
    
}
