<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Traits\ResponseHandler;

class CartService
{
    use ResponseHandler;

    public function addToCart($request)
    {
        $getProduct = new ProductService()->getProductById($request->product_id);

        if (!$getProduct) return $this->errorResponse('Product not found or unavailable');

        $cart = $this->getUserCartSlim();

        if (!$cart) {
            $cart = $this->createCart();

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'price' => $getProduct->price,
                'title' => $request->title,
                'quantity' => $request->quantity,
                'image' => $request->image
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'price' => $getProduct->price,
                'title' => $request->title,
                'quantity' => $request->quantity,
                'image' => $request->image
            ]);
        }
    }

    public function getUserCartSlim()
    {
        return Cart::where('user_id', auth()->user()->id)->first();
    }

    public function createCart()
    {
        return Cart::create(['user_id' => auth()->user()->id]);
    }
}
