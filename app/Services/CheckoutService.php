<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
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

    public function confirmPayment($request)
    {
        DB::beginTransaction();

        try {
            $response = Http::withToken(config('app.paystackSecret'))
                ->get("https://api.paystack.co/transaction/verify/{$request->reference_no}");

            $cartService = new CartService();
            $getCart = $cartService->getUserCartWithItems();

            if ($response->successful() && $response['data']['status'] === 'success') {
            // if ($response['data']['status'] === 'success') {
                if ($getCart->payment_reference != $request->reference_no) {
                    return $this->errorResponse('Payment reference and cart mismatch');
                }

                $getItemTotal = $this->getTotalProperty($getCart->items);

                $order = $this->createOrder($response['data']['status'], $getItemTotal, $request);

                $this->orderItemsCreate($getCart->items, $order->id);

                // if all is good, delete cart
                $cartService->deleteCart();

                // dispatch event if it meets crtiteria
            } else {
                if ($getCart->payment_reference != $request->reference_no) {
                    return $this->errorResponse('Payment reference and cart mismatch');
                }

                $getItemTotal = $this->getTotalProperty($getCart->items);

                $order = $this->createOrder($response['data']['status'], $getItemTotal, $request);

                $this->orderItemsCreate($getCart->items, $order->id);

                // we need to delete cart for the failed transaction
                $cartService->deleteCart();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->errorResponse('Unable to checkout user');
        }
    }

    public function createOrder($paymentStatus, $total, $request)
    {
        return Order::create([
            'order_code' => $request->reference_no,
            'user_id' => $request->user()->id,
            'total_amount' => $total,
            'payment_status' => $paymentStatus == 'success' ? 'paid' : 'not_paid',
            'transaction_type' => 'paystack',
            'payment_reference' => $request->reference_no,
            'cashback_unlocked' => 0
        ]);
    }

    public function orderItemsCreate($items, $orderId)
    {
        $itemsCreated = [];
        foreach ($items as $item) {
            $itemsCreated[] = [
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'title' => $item->title,
                'image' => $item->image,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return OrderItem::insert($itemsCreated);
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
