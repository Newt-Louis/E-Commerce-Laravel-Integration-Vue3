<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','description','gender','origin','views','item_type_id'];
    /**
     *
     * Relationships
     *
     */
    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }
    public function capacities(): BelongsToMany
    {
        return $this->belongsToMany(Capacity::class, 'product_details')
        ->withPivot('supplier', 'inventory', 'price', 'discount', 'created_at', 'updated_at')
        ->withTimestamps();
    }
    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     *
     * Accessor & Mutator
     *
     */

}
