<?php

namespace App\Providers;

use App\Events\BadgeUnlocked;
use App\Events\PurchaseConfirmed;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;
use App\Listeners\PurchaseConfirmedListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PurchaseConfirmed::class => [
            PurchaseConfirmedListener::class
        ],
        AchievementUnlockedListener::class => [
            AchievementUnlockedListener::class
        ],
        BadgeUnlocked::class => [
            BadgeUnlockedListener::class
        ]
    ];
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap services.
     */
    // public function boot(): void
    // {
    //     //
    // }
}
