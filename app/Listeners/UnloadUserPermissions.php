<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UnloadUserPermissions
{
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
    public function handle(Logout $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;
        $user->forgetPermissionCache();
    }
}
