<?php

declare(strict_types=1);

namespace Database\Factories\Solution\Catalog\Models;

use App\Solution\Catalog\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->unique()->text(10),
            'sku'   => $this->faker->unique()->uuid(),
            'price' => $this->faker->randomFloat(2, 5, 500),
        ];
    }
}
