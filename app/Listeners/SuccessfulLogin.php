<?php

namespace App\Listeners;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SuccessfulLogin
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
    public function handle(Login $event): void
    {
        $user = $event->user;
        
        Activity::create([
            'subject'  => 'Log in',
            'content' => sprintf(
                '%s [%s] logged in at %s.',
                $user->name,
                $user->username,
                Carbon::now()->toDayDateTimeString()
            ),
        ]);
    }
}
