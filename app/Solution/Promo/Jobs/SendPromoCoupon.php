<?php
declare(strict_types=1);

namespace App\Solution\Promo\Jobs;

use App\Solution\Checkout\Models\Order;
use App\Solution\Promo\Mail\FirstOrderPromo;
use App\Solution\Promo\Models\DiscountCoupon;
use App\Solution\User\Models\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendPromoCoupon implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     *
     * @return string
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
