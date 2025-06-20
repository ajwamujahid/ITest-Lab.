<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleCollection extends Model
{
    protected $fillable = [
        'patient_id', 'rider_id', 'test_type', 'address', 'status', 'assigned_at'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function rider() {
        return $this->belongsTo(Rider::class);
    }
}
