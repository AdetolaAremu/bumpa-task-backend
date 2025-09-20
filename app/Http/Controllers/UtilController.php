<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Services\UtilService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    use ResponseHandler;

    public function getUserStats(UtilService $utilService)
    {
        $stats = $utilService->getUseOrderStats();

        return $this->successResponse('Stats retrieved successfully', $stats);
    }

    public function getUserOrders(PaginationRequest $request, UtilService $utilService)
    {
        $orders = $utilService->getAllUserOrders($request);

        return $this->successResponse('Orders retrieved successfully', $orders);
    }

    public function getAllAchievements(UtilService $utilService)
    {
        $achievement = $utilService->allAchievements();

        return $this->successResponse('Acheievements retrieved successfully', $achievement);
    }

    public function getAllBadges(UtilService $utilService)
    {
        $badges = $utilService->allBadges();

        return $this->successResponse('Badges retrieved successfully', $badges);
    }

    public function getAllUserAchievements(UtilService $utilService)
    {
        $achievement = $utilService->userAchievements();

        return $this->successResponse('Acheievements retrieved successfully', $achievement);
    }

    public function getAllUserBadges(UtilService $utilService)
    {
        $badges = $utilService->userBadges();

        return $this->successResponse('Badges retrieved successfully', $badges);
    }

    public function getUserCashbackTotal(UtilService $utilService)
    {
        $cashback = $utilService->getAllUserCashBackTotal();

        return $this->successResponse('Badges retrieved successfully', $cashback);
    }
}
