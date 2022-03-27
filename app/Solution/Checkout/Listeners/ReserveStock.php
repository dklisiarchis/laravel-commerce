<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Listeners;

use App\Solution\Checkout\Events\OrderPlaced;
use App\Solution\Checkout\Models\CartItem;
use App\Solution\Checkout\Models\Order;
use App\Solution\Promo\Jobs\SendPromoCoupon as SendPromoCouponJob;
use App\Solution\Promo\Services\CouponManagement;
use App\Solution\Stock\Models\StockItem;
use App\Solution\Stock\Services\StockService;

class ReserveStock
{

    private $stockService;


    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * @param  OrderPlaced $event
     * @return void
     */
    public function handle(OrderPlaced $event): void
    {
       // Remove stock from bought items
    }
}
