<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    protected $table = 'patients'; // 👈 force Laravel to use 'patients' table

    protected $fillable = [
        'name', 'email', 'phone', 'age', 'gender', 'dob', 'address',
        'tests', 'branch', 'payment_method', 'total_amount'
    ];
    
    public function testRequests()
{
    return $this->hasMany(TestRequest::class);
}
public function reviews()
{
    return $this->hasMany(RiderReview::class);
}


    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function conversations()
    {
        return $this->morphToMany(
            Conversation::class,
            'participant',
            'conversation_participants',
            'participant_id',
            'conversation_id'
        );
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }
    
}
