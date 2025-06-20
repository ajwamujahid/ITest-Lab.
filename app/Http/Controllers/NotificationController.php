<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Ye function header ke liye notifications data laayega
    public function headerNotifications()
    {
        // Logged in user ke unread notification count
        $unreadNotificationCount = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        // Latest 5 notifications
        $headerNotifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Return a view jahan header notification show ho
        // Ya agar aap ye data har page pe chahiye to middleware me bhi bhej sakte hain
        return view('layouts.components.header', compact('unreadNotificationCount', 'headerNotifications'));
    }


    // Optional: notifications list page (View All)
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);  // Pagination agar chahiye

        return view('layouts.components.header', compact('notifications'));
    }

    // Optional: mark notification as read (AJAX ya button se call karne ke liye)
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
