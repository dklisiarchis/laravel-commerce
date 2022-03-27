<?php
declare(strict_types=1);

namespace App\Solution\Promo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property-read string $code
 * @property-read ?string $email
 * @property-read string $type
 * @property-read float $value
 * @property bool $valid
 * @property int $id
 */
class DiscountCoupon extends Model
{

    use HasFactory;

    public const TYPE_PERCENT = 'percent';
    public const TYPE_FIXED = 'fixed';

    protected $table = 'coupons';

    protected $attributes = [
        'code' => null,
        'email' => null,
        'type' => self::TYPE_FIXED,
        'value' => 0,
        'valid' => false
    ];

    protected $fillable = [
        'code',
        'email',
        'type',
        'value',
        'valid'
    ];
}
