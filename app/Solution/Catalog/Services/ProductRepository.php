<?php

declare(strict_types=1);

namespace App\Solution\Catalog\Services;

use App\Solution\Catalog\Models\Product;

class ProductRepository
{
    public function getById(int $productId): Product
    {
        return Product::findOrFail($productId);
    }

    public function getBySku(string $sku): Product
    {
        return Product::where('sku', $sku)->firstOrFail();
    }
}
