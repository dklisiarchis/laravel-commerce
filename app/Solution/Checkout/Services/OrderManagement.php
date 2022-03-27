<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Services;

use App\Solution\User\Models\User;
use App\Solution\User\Models\Address;
use App\Solution\Checkout\Models\Cart;
use App\Solution\Checkout\Models\Order;
use App\Solution\Checkout\Events\OrderPlaced;
use App\Solution\Promo\Services\CouponManagement;

class OrderManagement
{
    /**
     * @var CouponManagement
     */
    private $couponManagement;

    public function __construct(CouponManagement $couponManagement)
    {
        $this->couponManagement = $couponManagement;
    }

    /**
     * @throws \Throwable
     */
    public function placeOrder(
        Cart $cart,
        Address $address,
        string $email,
        ?User $user = null,
        ?string $couponCode = null
    ): Order {
        if ($couponCode) {
            $this->applyDiscountCode($cart, $couponCode);
        }

        /** @var Order $order */
        $order = Order::factory([
            'cart_id'             => $cart->id,
            'shipping_address_id' => $address->id,
            'billing_address_id'  => $address->id,
            'customer_email'      => $email,
            'customer_notified'   => false,
            'customer_id'         => null === $user ? null : $user->id,
            'discount_code'       => $cart->coupon_code,
            'discount'            => $cart->discount,
            'grand_total'         => $cart->grand_total,
        ])->makeOne();
        $order->saveOrFail();
        $order->refresh();
        if ($order->discount_code) {
            $this->couponManagement->invalidate($order->discount_code);
        }

        OrderPlaced::dispatch($order);

        return $order;
    }

    private function applyDiscountCode(Cart $cart, string $code): void
    {
        $this->couponManagement->apply($code, $cart);
        $cart->refresh();
    }
}
