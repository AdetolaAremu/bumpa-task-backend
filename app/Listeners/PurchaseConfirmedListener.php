<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\PurchaseConfirmed;
use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PurchaseConfirmedListener
{
    /**
     * Handle the event.
     */
    public function handle(PurchaseConfirmed $event): void
    {
        $user = $event->user;

        $purchasesCount = $user->orders()->count();
        $totalSpent     = $user->orders()->sum('total_amount');

        // Achievements
        foreach (Achievement::all() as $achievement) {
            $unlocked = false;

            if ($achievement->condition_type === 'purchases_count' &&
                $purchasesCount >= $achievement->condition_value) {
                $unlocked = true;
            }

            if ($achievement->condition_type === 'total_spent' &&
                $totalSpent >= $achievement->condition_value) {
                $unlocked = true;
            }

            if ($unlocked && !$user->achievements->contains($achievement->id)) {
                $user->achievements()->attach($achievement->id);

                event(new AchievementUnlocked($user, $achievement));
            }
        }

        // Badges
        $unlockedCount = $user->achievements()->count();

        foreach (Badge::all() as $badge) {
            if ($unlockedCount >= $badge->required_achievements &&
                !$user->badges->contains($badge->id)) {
                $user->badges()->attach($badge->id);

                event(new BadgeUnlocked($user, $badge));
            }
        }
    }
}
