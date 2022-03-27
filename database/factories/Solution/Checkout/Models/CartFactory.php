<?php

declare(strict_types=1);

namespace Database\Factories\Solution\Checkout\Models;

use App\Solution\Checkout\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'          => null,
            'shipping_cost'    => 0,
            'base_grand_total' => 0,
            'coupon_code'      => null,
            'total_items'      => 0,
            'discount'         => 0,
            'grand_total'      => 0,
            'is_active'        => true,
        ];
    }
}
