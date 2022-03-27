<?php
declare(strict_types=1);

namespace App\Solution\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $country_id
 * @property string $street
 * @property string $addition
 * @property string $postcode
 * @property string $telephone
 * @property boolean $default_shipping
 * @property boolean $default_billing
 * @property int|null $user_id
 */
class Address extends Model
{
    use HasFactory;

    /**
     * DB table
     * @var string
     */
    protected $table = 'user_address';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'user_id' => null,
        'first_name' => '',
        'last_name' => '',
        'country_id' => '',
        'street' => '',
        'addition' => '',
        'postcode' => '',
        'telephone' => '',
        'default_shipping' => false,
        'default_billing' => false
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
