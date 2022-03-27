<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Listeners;

use App\Solution\Checkout\Events\OrderPlaced;
use App\Solution\Stock\Services\StockService;

class ReserveStock
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function handle(OrderPlaced $event): void
    {
        // Remove stock from bought items
    }
}
