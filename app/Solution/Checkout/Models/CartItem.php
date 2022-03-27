<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read int $cart_id
 * @property-read int $product_id
 * @property int $qty
 * @property float $row_total
 * @property int $id
 */
class CartItem extends Model
{

    use HasFactory;

    protected $table = 'checkout_cart_item';

    protected $attributes = [
        'cart_id' => null,
        'product_id' => null,
        'qty' => 0,
        'row_total' => 0
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
