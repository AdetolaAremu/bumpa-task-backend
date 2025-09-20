<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Traits\ResponseHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartService
{
    use ResponseHandler;

    public function addToCart($request)
    {
        DB::beginTransaction();

        try {
            $getProductService = new ProductService();
            $getProduct = $getProductService->getProductById($request->product_id);

            if (!$getProduct) {
                return $this->errorResponse('Product not found or unavailable');
            }

            $cart = $this->getUserCartSlim();

            if (!$cart) {
                $cart = $this->createCart();
            }

            $itemCheck = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($itemCheck) {
                $itemCheck->quantity += 1;
                $itemCheck->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                    'price' => $getProduct->price,
                    'title' => $getProduct->title,
                    'quantity' => $request->quantity,
                    'image' => $getProduct->image_url,
                    'user_id' => $request->user()->id,
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->errorResponse('Error adding item to cart');
        }
    }


    public function itemExistCheck($productId)
    {
        return CartItem::where('product_id', $productId)
            ->where('user_id', auth()->user()->id)->first();
    }

    public function getUserCartSlim()
    {
        return Cart::where('user_id', auth()->user()->id)->first();
    }

    public function getUserCartWithItems()
    {
        return Cart::where('user_id', auth()->user()->id)->with('items')->first();
    }

    public function createCart()
    {
        return Cart::create(['user_id' => auth()->user()->id]);
    }

    public function deleteCart()
    {
        $cart = $this->getUserCartWithItems();

        $cart->items()->delete();

        $cart->delete();
    }

    public function deleteCartItems($cartItemId)
    {
        $cartItem = CartItem::where('product_id', $cartItemId)->first();

        if (!$cartItem) return null;

        return $cartItem->delete();
    }
}
