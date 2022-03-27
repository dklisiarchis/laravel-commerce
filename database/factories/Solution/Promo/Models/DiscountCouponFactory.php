<?php

declare(strict_types=1);

namespace Database\Factories\Solution\Promo\Models;

use App\Solution\Promo\Models\DiscountCoupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountCouponFactory extends Factory
{
    protected $model = DiscountCoupon::class;

    private const TYPES = [DiscountCoupon::TYPE_FIXED, DiscountCoupon::TYPE_PERCENT];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'  => $this->faker->uuid(),
            'email' => $this->faker->email(),
            'type'  => $this->faker->randomElement(self::TYPES),
            'value' => $this->faker->numberBetween(5, 85),
            'valid' => true,
        ];
    }
}
