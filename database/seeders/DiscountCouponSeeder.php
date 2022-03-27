<?php

namespace Database\Seeders;

use App\Solution\Promo\Models\DiscountCoupon;
use Illuminate\Database\Seeder;

class DiscountCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 11; $i++) {
            DiscountCoupon::factory([
                'code' => 'coupon_' . $i,
                'type' => ($i % 2 === 0) ? DiscountCoupon::TYPE_PERCENT : DiscountCoupon::TYPE_FIXED,
                'value' => $i * 2,
                'valid' => true
            ])->create();
        }
    }
}
