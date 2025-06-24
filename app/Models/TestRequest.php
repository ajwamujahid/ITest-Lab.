<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'name',
        'email',
        'phone',
        'age',
        'gender',
        'address',
        'tests',        // ✅ Good
        'branch',
        'payment_method',
        'total_amount',
        'rider_id',     // ✅ Good
    ];
    
    protected $casts = [
        'tests' => 'array',
    ];
    public function appointment()
{
    return $this->hasOne(Appointment::class, 'test_request_id'); // ✅ best and clean
}

    
    // public function patient()
    // {
    //     return $this->belongsTo(Patient::class, 'patient_id');
    // }
    
  
    
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
    
// nothing extra needed, unless you want:
public function riderVisit()
{
    return $this->hasOne(RiderVisit::class, 'test_request_id');
}
// App\Models\TestRequest.php

public function patient()
{
    return $this->belongsTo(Patient::class);
}

// Optional: if you ever want to know visits from TestRequest
public function visits()
{
    return $this->hasMany(RiderVisit::class);
}
public function tests()
{
    return $this->belongsToMany(Test::class, 'test_request_test')
        ->withPivot('quantity', 'price');
}

public function branch()
{
    return $this->belongsTo(Branch::class);
}

// public function patient()
// {
//     return $this->belongsTo(Patient::class);
// }


}
