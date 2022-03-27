<?php

declare(strict_types=1);

namespace App\Solution\Stock\Services;

use App\Solution\Stock\Models\StockItem;
use App\Solution\Catalog\Services\ProductRepository;

class StockService
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

    public function getStockByProductId(int $productId): StockItem
    {
        return StockItem::where('product_id', $productId)->firstOrFail();
    }

    public function getStockBySku(string $sku): StockItem
    {
        $product = $this->productRepository->getBySku($sku);

        return $this->getStockByProductId($product->id);
    }

    /**
     * @param string|int $productId
     */
    public function isInStock($productId): bool
    {
        $stockItem = is_string($productId)
            ? $this->getStockBySku($productId)->qty
            : $this->getStockByProductId($productId);

        return $stockItem->qty > 0;
    }

    public function hasEnoughStock(int $productId, int $qtyRequested): bool
    {
        $stock = $this->getStockByProductId($productId);

        return $stock->qty >= $qtyRequested;
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $productId, int $qty = 1): void
    {
        $stockItem = $this->getStockByProductId($productId);
        if ($qty > $stockItem->qty) {
            throw new \InvalidArgumentException('Product is not available in the requested quantity');
        }

        $stockItem->qty -= $qty;
        $stockItem->saveOrFail();
    }

    /**
     * @throws \Throwable
     */
    public function restore(int $productId, int $qty = 1): void
    {
        $stockItem = $this->getStockByProductId($productId);
        $stockItem->qty += abs($qty);
        $stockItem->saveOrFail();
    }
}
