<?php
declare(strict_types=1);

namespace App\Solution\Catalog\Models;

use App\Solution\Stock\Models\StockItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $sku
 * @property-read float $price
 */
class Product extends Model
{

    use HasFactory;

    protected $table = 'catalog_product_entity';

    protected $fillable = [
        'name',
        'sku',
        'price',
    ];

    public function stockItem(): HasOne
    {
        return $this->hasOne(StockItem::class);
    }
}
