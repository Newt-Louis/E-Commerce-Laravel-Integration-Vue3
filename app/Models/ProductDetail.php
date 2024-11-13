<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['product_id','capacity_id','supplier','inventory','price','discount'];


    /**
     * Relationships
     */
    public function capacity(): BelongsTo
    {
        return $this->belongsTo(Capacity::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }

    /**
     * Accessor & Mutators
     */
    protected function inventory(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $value === '' ? null : (int) $value,
        );
    }
    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $value === '' ? null : (int) $value,
        );
    }
    protected function discount(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $value === '' ? null : (float) str_replace(',', '.', $value),
        );
    }

}
