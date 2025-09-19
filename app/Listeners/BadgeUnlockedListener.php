<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeUnlockedListener
{
    /**
     * Handle the event.
     */
    public function handle(BadgeUnlocked $event): void
    {
        $event->user->badges()->attach($event->badge->id);
    }
}
