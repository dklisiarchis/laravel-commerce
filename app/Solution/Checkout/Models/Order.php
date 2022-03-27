<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Models;

use App\Solution\User\Models\User;
use App\Solution\User\Models\Address;
use Illuminate\Database\Eloquent\Model;
use App\Solution\Promo\Models\DiscountCoupon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string      $order_id
 * @property string      $customer_email
 * @property int         $cart_id
 * @property ?int        $customer_id
 * @property bool        $customer_notified
 * @property float       $grand_total
 * @property int         $id
 * @property int         $shipping_address_id
 * @property int         $billing_address_id
 * @property string|null $discount_code
 * @property float       $discount
 */
class Order extends Model
{
    use HasFactory;

    protected $table = 'sales_order';

    protected $attributes = [
        'order_id'            => '',
        'cart_id'             => null,
        'shipping_address_id' => null,
        'billing_address_id'  => null,
        'customer_email'      => '',
        'customer_id'         => null,
        'customer_notified'   => false,
        'discount_code'       => null,
        'discount'            => 0,
        'grand_total'         => 0,
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function (Order $model) {
            $model->order_id = \Str::uuid();
        });
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function coupon(): HasOne
    {
        return $this->hasOne(DiscountCoupon::class);
    }
}
