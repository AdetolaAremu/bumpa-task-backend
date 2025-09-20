<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Order;
use App\Models\UserAchievement;
use App\Models\UserBadges;

class UtilService
{
    public function getUseOrderStats()
    {
        $userId = auth()->id();

        $stats = Order::selectRaw('
                COALESCE(SUM(cart_items.quantity), 0) as total_products,
                COALESCE(SUM(cart_items.price * cart_items.quantity), 0) as total_spent,
                COALESCE(SUM(CASE WHEN orders.status = "successful" THEN 1 ELSE 0 END), 0) as successful_orders,
                (
                    SELECT COUNT(*)
                    FROM user_achievements
                    WHERE user_id = ?
                ) as achievements
            ', [$userId])
            ->leftJoin('cart_items', 'orders.id', '=', 'cart_items.cart_id')
            ->where('orders.user_id', $userId)
            ->first();

        return $stats;
    }

    public function getAllUserOrders($request)
    {
        $userId = auth()->id();
        $pageSize = $request->pageSize ?? 15;

        if ($request->limit) {
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
        return UserAchievement::with('achievements')->get();
    }

    public function userBadges()
    {
        return UserBadges::with('badges')->get();
    }
}
