<?php
declare(strict_types=1);

namespace App\Solution\Stock\Services;

use App\Solution\Catalog\Models\Product;
use App\Solution\Catalog\Services\ProductRepository;
use App\Solution\Checkout\Models\Order;
use App\Solution\Stock\Models\StockItem;

class StockService
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductRepository|null $productRepository
     */
    public function __construct(
        ?ProductRepository $productRepository = null
    ) {
        $this->productRepository = $productRepository ?? new ProductRepository();
    }

    /**
     * @param int $productId
     * @return StockItem
     */
    public function getStockByProductId(int $productId): StockItem
    {
        return StockItem::where('product_id', $productId)->firstOrFail();
    }

    /**
     * @param string $sku
     * @return StockItem
     */
    public function getStockBySku(string $sku): StockItem
    {
        $product = $this->productRepository->getBySku($sku);
        return $this->getStockByProductId($product->id);
    }

    /**
     * @param string|int $productId
     * @return bool
     */
    public function isInStock($productId): bool
    {
        $stockItem = is_string($productId)
            ? $this->getStockBySku($productId)->qty
            : $this->getStockByProductId($productId);
        return $stockItem->qty > 0;
    }

    /**
     * @param int $productId
     * @param int $qtyRequested
     * @return bool
     */
    public function hasEnoughStock(int $productId, int $qtyRequested): bool
    {
        $stock = $this->getStockByProductId($productId);
        return $stock->qty >= $qtyRequested;
    }

    /**
     * @param int $productId
     * @param int $qty
     * @return void
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
     * @param int $productId
     * @param int $qty
     * @return void
     * @throws \Throwable
     */
    public function restore(int $productId, int $qty = 1): void
    {
        $stockItem = $this->getStockByProductId($productId);
        $stockItem->qty += abs($qty);
        $stockItem->saveOrFail();
    }
}
