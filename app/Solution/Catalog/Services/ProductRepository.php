<?php
declare(strict_types=1);

namespace App\Solution\Catalog\Services;

use App\Solution\Catalog\Models\Product;

class ProductRepository
{

    /**
     * @param int $productId
     * @return Product
     */
    public function getById(int $productId): Product
    {
        return Product::findOrFail($productId);
    }

    /**
     * @param string $sku
     * @return Product
     */
    public function getBySku(string $sku): Product
    {
        return Product::where('sku', $sku)->firstOrFail();
    }
}
