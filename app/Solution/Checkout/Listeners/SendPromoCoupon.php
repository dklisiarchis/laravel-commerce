<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Listeners;

use App\Solution\Checkout\Models\Order;
use App\Solution\Checkout\Events\OrderPlaced;
use App\Solution\Promo\Services\CouponManagement;
use App\Solution\Promo\Jobs\SendPromoCoupon as SendPromoCouponJob;

class SendPromoCoupon
{
    private $couponManagement;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CouponManagement $couponManagement)
    {
        $this->couponManagement = $couponManagement;
    }

    public function handle(OrderPlaced $event): void
    {
        SendPromoCouponJob::dispatchIf(
            $this->isFirstOrder($event->order),
            $event->order,
            $this->couponManagement->generate(5, $event->order->customer_email)
        )->delay(now()->addMinutes(15));
    }

    private function isFirstOrder(Order $order): bool
    {
        return true;
    }
}
