<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Solution\Catalog\Models\Product;
use App\Solution\Stock\Models\StockItem;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)
            ->has(StockItem::factory()->count(1))
            ->create();
    }
}
