<?php
declare(strict_types=1);

namespace Database\Factories\Solution\Checkout\Models;

use App\Solution\Checkout\Models\Cart;
use App\Solution\Checkout\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{

    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cart_id' => null,
            'product_id' => null,
            'qty' => 0,
            'row_total' => 0
        ];
    }
}
