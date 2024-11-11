<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['product_id','capacity_id','supplier','inventory','price','discount'];

    public function capacity(): BelongsTo
    {
        return $this->belongsTo(Capacity::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function collections(): HasManyThrough
    {
        return $this->hasManyThrough(Collection::class, CollectionProductDetail::class, 'product_id', 'product_id', 'product_id', 'collection_id');
    }
}
