<?php

declare(strict_types=1);

namespace App\Solution\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use App\Solution\Stock\Models\StockItem;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int    $id
 * @property string $name
 * @property string $sku
 * @property float  $price
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
