<?php

namespace Database\Seeders;

use App\Solution\Catalog\Models\Product;
use App\Solution\Stock\Models\StockItem;
use Illuminate\Database\Seeder;

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
