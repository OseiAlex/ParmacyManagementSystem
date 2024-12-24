<?php

namespace App\Listeners;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SuccessfulLogout
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
        $user = $event->user;
        
        Activity::create([
            'subject'  => 'Log out',
            'content' => sprintf(
                '%s [%s] logged out at %s.',
                $user->name,
                $user->username,
                Carbon::now()->toDayDateTimeString()
            ),
        ]);
    }
}
