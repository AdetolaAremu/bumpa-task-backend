<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\Cashback;
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

        Cashback::create([
            'user_id' => $event->user->id,
            'amount' => 300.00,
            'order_code' => $event->order->order_code
        ]);
    }
}
