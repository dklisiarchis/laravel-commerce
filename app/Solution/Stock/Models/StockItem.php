<?php

declare(strict_types=1);

namespace App\Solution\Stock\Models;

use Illuminate\Database\Eloquent\Model;
use App\Solution\Catalog\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int product_id
 * @property int qty
 */
class StockItem extends Model
{
    use HasFactory;

    protected $table = 'catalog_stock_item';

    protected $fillable = [
        'product_id',
        'qty',
    ];

    public $timestamps = false;

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
