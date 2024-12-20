<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_at','end_at'];

    /**
     *
     * Relationships
     *
    */
    public function productDetails(): BelongsToMany
    {
        return $this->belongsToMany(ProductDetail::class);
    }

    /**
     *
     * Accessor & Mutators
     *
     * */

    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Carbon::parse($value)->format('d-m-Y H:i') : null,
            set: fn (?string $value) => $value ? Carbon::parse($value) : null,
        );
    }
    protected function endAt(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Carbon::parse($value)->format('d-m-Y H:i') : null,
            set: fn (?string $value) => $value ? Carbon::parse($value) : null,
        );
    }
}
