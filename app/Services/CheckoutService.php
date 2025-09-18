<?php

namespace App\Services;

use App\Traits\ResponseHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutService
{
    use ResponseHandler;

    public function checkout()
    {
        DB::beginTransaction();

        try {
            $cartService = new CartService();
            $userCart = $cartService->getUserCartWithItems();
            $authUser = Auth::user();

            if (!$userCart) return $this->errorResponse('Cart does not exists', 404);

            $paystack_reference_id = $this->generatePaymentReference();

            $userCart->update(['payment_reference' => $paystack_reference_id]);

            $getItemTotal = $this->getTotalProperty($userCart->items);

            $response = Http::withToken(config('app.paystackSecret'))
                ->post('https://api.paystack.co/transaction/initialize', [
                    'email' =>  $authUser->email,
                    'amount' => $getItemTotal * 100,
                    'callback_url' => config('app.paystackCallbackUrl'),
                    'reference' => $paystack_reference_id,
                    'metadata' => [
                        'cart_id' => $userCart->id,
                    ]
                ]);

            if (!$response->successful()) {
                return $this->errorResponse('Checkout failed, please retry');
            }

            DB::commit();

            return $response['data']['authorization_url'];
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->errorResponse('Checkout failed due internal error, please retry');
        }
    }

    public function confirmPayment()
    {
        // move all cart items to orders

        // delete cart

        // confirm payment and update order status

        // here is where all the magic will happen for the badge and achievement events
    }

    public function createOrder()
    {

    }

    public function getTotalProperty($cartItems)
    {
        if (!$cartItems) return 0;
        // dd('got here', $cartItems);
        return $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    private function generatePaymentReference()
    {
        return 'ORD_' . time() . '_' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }
}
