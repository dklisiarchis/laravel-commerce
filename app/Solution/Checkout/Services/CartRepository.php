<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Services;

use App\Solution\Checkout\Models\Cart;

class CartRepository
{

    public function getById(int $cartId): ?Cart
    {
        return Cart::where('id', $cartId)->firstOr(function () {
            $cart = Cart::factory()->makeOne();
            $cart->save();
            return $cart;
        });
    }

    public function getByUserId(int $userId): Cart
    {
        return Cart::where('user_id', $userId)->firstOrFail();
    }
}
