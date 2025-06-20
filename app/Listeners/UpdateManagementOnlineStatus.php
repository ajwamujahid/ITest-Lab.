<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateManagementOnlineStatus
{
    public function login(Login $event)
    {
        if (get_class($event->user) === \App\Models\Management::class) {
            $event->user->update(['is_online' => true]);
        }
    }

    public function logout(Logout $event)
    {
        if (get_class($event->user) === \App\Models\Management::class) {
            $event->user->update(['is_online' => false]);
        }
    }
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
