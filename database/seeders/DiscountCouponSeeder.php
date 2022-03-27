<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Solution\Promo\Models\DiscountCoupon;

class DiscountCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 11; ++$i) {
            DiscountCoupon::factory([
                'code'  => 'coupon_'.$i,
                'type'  => (0 === $i % 2) ? DiscountCoupon::TYPE_PERCENT : DiscountCoupon::TYPE_FIXED,
                'value' => $i * 2,
                'valid' => true,
            ])->create();
        }
    }
}
