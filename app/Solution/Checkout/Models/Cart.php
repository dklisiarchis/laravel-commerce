<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

/**
 * @property-read int $id
 * @property ?int $user_id
 * @property float $base_grand_total
 * @property float $grand_total
 * @property ?string $coupon_code
 * @property float $discount
 * @property int $total_items
 * @property boolean $is_active
 */
class Cart extends Model
{

    use HasFactory;

    protected $table = 'checkout_cart';

    protected $attributes = [
        'user_id' => null,
        'shipping_cost' => 0,
        'base_grand_total' => 0,
        'total_items' => 0,
        'coupon_code' => null,
        'discount' => 0,
        'grand_total' => 0,
        'is_active' => true
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'is_active'
    ];

    public function isGuestCart(): bool
    {
        return $this->user_id !== null;
    }

    public function cartItems(): HasOneOrMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * @return CartItem[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCartItems()
    {
        return CartItem::where('cart_id', $this->id)->get();
    }

    /**
     * @param int $productId
     * @return CartItem|null
     */
    public function getCartItem(int $productId): ?CartItem
    {
        $search = ['cart_id' => $this->id, 'product_id' => $productId];
        return CartItem::where($search)->firstOr(function () {
            return null;
        });
    }
}
