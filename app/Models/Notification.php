<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read', // boolean flag for read/unread
    ];


public function getNotifications()
{
    $notifications = Notification::latest()->take(5)->get();
    $unreadCount = Notification::where('is_read', false)->count();

    return view('your-view-file', compact('notifications', 'unreadCount'));
}

}
