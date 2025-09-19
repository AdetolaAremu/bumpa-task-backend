<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentConfirmationRequest;
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

    // check payment and checkout
    public function paymentConfirmation(CheckoutService $checkoutService, PaymentConfirmationRequest $request)
    {
        $confirmPayment = $checkoutService->confirmPayment($request);

        if ($this->errorInstance($confirmPayment)) return $confirmPayment;

        return $this->successResponse('Payment successfully checked', null);
    }
}
