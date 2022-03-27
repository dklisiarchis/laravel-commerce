<?php
declare(strict_types=1);

namespace App\Solution\Stock\Models;

use App\Solution\Catalog\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
