<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\User; // import User model

class UpdateLastLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $user->update([
            'last_login' => now(),
        ]);
    }
}
