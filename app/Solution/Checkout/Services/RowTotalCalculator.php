<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Services;

use App\Solution\Catalog\Services\ProductRepository;

class RowTotalCalculator
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        ?ProductRepository $productRepository = null
    ) {
        $this->productRepository = $productRepository ?? new ProductRepository();
    }

    /**
     * @param int $productId
     * @param int $qty
     * @return float
     */
    public function calculate(int $productId, int $qty): float
    {
        $product = $this->productRepository->getById($productId);
        $basePrice = $product->price;
        return $basePrice * $qty;
    }
}
