<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    use ResponseHandler;

    // initiate payment
    public function initializePayment(CheckoutService $checkoutService)
    {
        $checkout = $checkoutService->checkout();

        if ($this->errorInstance($checkout)) return $checkout;

        return $this->successResponse('Initialized payment successfully', $checkout);
    }
}
