<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'rider_id',
        'test_request_id',
        'status',
        'scheduled_at',
        'verification_code',
        'vehicle_info',
        'rider_photo',
    ];

    public function testRequest()
    {
        return $this->belongsTo(TestRequest::class, 'test_request_id');
    }
    
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
    
// App\Models\RiderVisit.php

// public function rider()
// {
//     return $this->belongsTo(Rider::class);
// }

// public function testRequest()
// {
//     return $this->belongsTo(TestRequest::class);
// }

    // ✅ Dynamic accessor: computed 'tests'
    public function getTestsAttribute()
    {
        return $this->testRequest ? $this->testRequest->tests : collect();
    }
}
