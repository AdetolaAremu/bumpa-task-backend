<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Services\CartService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    use ResponseHandler;

    // get cart
    public function getUserCart(CartService $cartService)
    {
        $cart = $cartService->getUserCartWithItems();

        return $this->successResponse('Cart retrieved successfully', $cart);
    }

    // add to cart
    public function addToCart(AddCartRequest $request, CartService $cartService)
    {
        $cartCreate = $cartService->addToCart($request);

        if ($this->errorInstance($cartCreate)) return $cartCreate;

        return $this->successResponse('Item added to cart successfully', null);
    }

    // delete item from cart
    public function deleteCartItem($cartItemId, CartService $cartService)
    {
        $item = $cartService->deleteCartItems($cartItemId);

        if (!$item) return $this->errorResponse('Item does not exist in your cart', 404);

        return $this->successResponse('Item deleted successfully', null);
    }

    // delete cart
    public function deleteCart(CartService $cartService)
    {
        $cartService->deleteCart();

        return $this->successResponse('Cart emptied successfully', null);
    }
}
