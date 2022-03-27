<?php
declare(strict_types=1);

namespace App\Solution\Promo\Services;

use App\Solution\Checkout\Models\Cart;
use App\Solution\Promo\Models\DiscountCoupon;

class CouponManagement
{

    private $couponRepository;

    public function __construct(?CouponRepository $couponRepository = null)
    {
        $this->couponRepository = $couponRepository ?? new CouponRepository();
    }

    public function apply(string $couponCode, Cart $cart): Cart
    {
        try {
            $coupon = $this->couponRepository->getByCode($couponCode);
            $cartBaseTotal = $cart->base_grand_total;
            $cartGrandTotal = $cart->grand_total;
            switch ($coupon->type) {
                case DiscountCoupon::TYPE_FIXED:
                    $newCartBaseTotal =- abs($coupon->value);
                    $newCartGrandTotal =- abs($coupon->value);
                    break;
                case DiscountCoupon::TYPE_PERCENT:
                    $newCartBaseTotal = $cartBaseTotal - ($cartBaseTotal * $coupon->value / 100);
                    $newCartGrandTotal = $cartGrandTotal - ($cartGrandTotal * $coupon->value / 100);
                    break;
                default:
                    $newCartBaseTotal = $cartBaseTotal;
                    $newCartGrandTotal = $cartGrandTotal;
                    break;
            }

            $cart->base_grand_total = $newCartBaseTotal;
            $cart->grand_total = $newCartGrandTotal;
            $cart->discount = $cartGrandTotal - $newCartGrandTotal;
            $cart->coupon_code = $coupon->code;
            $cart->save();
            return $cart;
        } catch (\Throwable $e) {
            return $cart;
        }
    }

    public function invalidate(string $couponCode): void
    {
        $coupon = $this->couponRepository->getByCode($couponCode);
        $coupon->valid = false;
        $coupon->save();
    }

    public function generate(
        float $value,
        ?string $email = null,
        $type = DiscountCoupon::TYPE_FIXED,
    ): DiscountCoupon {
        /** @var DiscountCoupon $coupon */
        $coupon = DiscountCoupon::factory([
            'code' => \Str::random(10),
            'email' => $email,
            'type' => $type,
            'value' => $value,
            'valid' => true
        ])->make();
        $coupon->save();

        return $coupon;
    }
}
