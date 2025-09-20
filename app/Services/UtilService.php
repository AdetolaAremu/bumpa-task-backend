<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Cashback;
use App\Models\Order;
use App\Models\UserAchievement;
use App\Models\UserBadges;
use Illuminate\Support\Facades\Log;

class UtilService
{
    public function getUseOrderStats()
    {
        $userId = auth()->id();

        $stats = Order::selectRaw('
            COALESCE(SUM(order_items.quantity), 0) as total_products,
            COALESCE(SUM(order_items.price * order_items.quantity), 0) as total_spent,
            COALESCE(COUNT(DISTINCT CASE WHEN orders.payment_status = "paid" THEN orders.id END), 0) as successful_orders,
            (
                SELECT COUNT(*)
                FROM user_achievements
                WHERE user_id = ?
            ) as achievements
        ', [$userId])
        ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
        ->where('orders.user_id', $userId)
        ->first();

        return $stats;
    }

    public function getAllUserOrders($request)
    {
        $userId = auth()->id();
        $pageSize = $request->pageSize ?? 15;

        if ($request->limit) {
            Log::info($request->limit);
            $orders = Order::where('user_id', $userId)
                ->with('items')
                ->limit($request->limit)
                ->get();
        } else {
            $orders = Order::where('user_id', $userId)
                ->with('items')
                ->paginate($pageSize);
        }

        return $orders;
    }

    public function allAchievements()
    {
        return Achievement::get();
    }

    public function allBadges()
    {
        return Badge::get();
    }

    public function userAchievements()
    {
        $userId = auth()->id();

        return UserAchievement::where('user_id', $userId)->with('achievements')->get();
    }

    public function userBadges()
    {
        $userId = auth()->id();

        return UserBadges::where('user_id', $userId)->with('badges')->get();
    }

    public function getAllUserCashBackTotal()
    {
        $userId = auth()->id();

        return Cashback::where('user_id', $userId)->sum('amount');
    }

    public function userCombinedAchievementAndBadges()
    {
        $user = auth()->user();

        $allAchievements = Achievement::pluck('name')->toArray();

        $unlockedAchievements = $user->achievements()->pluck('name')->toArray();
        $unlockedCount = count($unlockedAchievements);

        $nextAvailable = array_values(array_diff($allAchievements, $unlockedAchievements));

        $badges = Badge::orderBy('required_achievements')->get();

        $currentBadge = null;
        $nextBadge = null;
        $remainingToNext = 0;

        foreach ($badges as $badge) {
            if ($unlockedCount >= $badge->required_achievements) {
                $currentBadge = $badge->name;
            } elseif ($unlockedCount < $badge->required_achievements && !$nextBadge) {
                $nextBadge = $badge->name;
                $remainingToNext = $badge->required_achievements - $unlockedCount;
            }
        }

        return [
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailable,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToNext,
        ];
    }
}
