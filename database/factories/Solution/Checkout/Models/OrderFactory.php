<?php

declare(strict_types=1);

namespace Database\Factories\Solution\Checkout\Models;

use App\Solution\Checkout\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'            => '',
            'cart_id'             => null,
            'shipping_address_id' => null,
            'billing_address_id'  => null,
            'customer_id'         => null,
            'customer_notified'   => false,
            'discount_code'       => null,
            'discount'            => 0,
            'grand_total'         => 0,
        ];
    }
}
