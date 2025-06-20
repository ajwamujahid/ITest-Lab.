<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Branch;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\UpdateManagementOnlineStatus;



class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            UpdateManagementOnlineStatus::class . '@login',
        ],
        Logout::class => [
            UpdateManagementOnlineStatus::class . '@logout',
        ],
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('branches', Branch::all());
            $notifications = Notification::latest()->take(5)->get();
            $unreadCount = Notification::where('is_read', false)->count();
            $view->with('headerNotifications', $notifications)->with('unreadNotificationCount', $unreadCount);
     
        });
        
    }
}
