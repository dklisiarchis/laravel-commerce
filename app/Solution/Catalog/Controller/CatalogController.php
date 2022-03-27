<?php

declare(strict_types=1);

namespace App\Solution\Catalog\Controller;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Solution\Catalog\Models\Product;
use App\Solution\Stock\Services\StockService;

class CatalogController extends Controller
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function getList(): JsonResponse
    {
        $products = Product::all()->toArray();
        foreach ($products as &$product) {
            $stockItem = $this->stockService->getStockBySku($product['sku']);
            $product['qty'] = $stockItem->qty;
        }

        return response()->json($products);
    }
}
