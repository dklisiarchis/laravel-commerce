<?php

declare(strict_types=1);

namespace App\Solution\Promo\Jobs;

use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Solution\Checkout\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Solution\Promo\Mail\FirstOrderPromo;
use App\Solution\Promo\Models\DiscountCoupon;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendPromoCoupon implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var DiscountCoupon
     */
    public $coupon;

    /**
     * @var Order
     */
    public $order;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 60;

    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return sprintf('sendCouponJob_%s', \Str::random());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Order $order, DiscountCoupon $discountCoupon)
    {
        Mail::to($order->customer_email)->send(new FirstOrderPromo($discountCoupon));
    }
}
