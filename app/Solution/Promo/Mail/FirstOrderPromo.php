<?php

declare(strict_types=1);

namespace App\Solution\Promo\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Solution\Promo\Models\DiscountCoupon;

class FirstOrderPromo extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var DiscountCoupon
     */
    public $discountCoupon;

    /**
     * @return void
     */
    public function __construct(DiscountCoupon $discountCoupon)
    {
        $this->discountCoupon = $discountCoupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('laravelCommerce@app.com', 'Laravel Commerce')
            ->view('emails.promo.first-order-promo');
    }
}
