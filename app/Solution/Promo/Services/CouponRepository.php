<?php

declare(strict_types=1);

namespace App\Solution\Promo\Services;

use App\Solution\Promo\Models\DiscountCoupon;

class CouponRepository
{
    public function getById(int $couponId): DiscountCoupon
    {
        return DiscountCoupon::findOrFail($couponId);
    }

    public function getByCode(string $couponCode, bool $validOnly = true): DiscountCoupon
    {
        return $validOnly
            ? DiscountCoupon::where(['code' => $couponCode, 'valid' => true])->firstOrFail()
            : DiscountCoupon::where('code', $couponCode)->firstOrFail();
    }
}
