<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderVisitTest extends Model
{
    use HasFactory;

    // 👇 Explicitly correct table name
    protected $table = 'rider_visit_test';

    protected $fillable = [
        'rider_visit_id',
        'test_id',
    ];

    public function riderVisit()
    {
        return $this->belongsTo(RiderVisit::class, 'rider_visit_id');
    }

    public function testRequest()
    {
        return $this->belongsTo(TestRequest::class, 'test_id');
    }
}
