<?php
declare(strict_types=1);

namespace Database\Factories\Solution\Stock\Models;

use App\Solution\Stock\Models\StockItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockItemFactory extends Factory
{

    protected $model = StockItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 10),
            'qty' => $this->faker->numberBetween(0, 15),
        ];
    }
}
