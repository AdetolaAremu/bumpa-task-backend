<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementUnlockedListener
{
    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event): void
    {
        // insert achievement
        $event->user->achievements()->attach($event->achievement->id);
    }
}
