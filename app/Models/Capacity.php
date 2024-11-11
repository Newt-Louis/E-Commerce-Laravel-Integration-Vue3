<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Capacity extends Model
{
    use HasFactory;

    protected $fillable = ['name','volume'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductDetail::class)
        ->as('products')
        ->withPivot('supplier', 'inventory', 'price', 'discount', 'created_at', 'updated_at')
        ->withTimestamps();
    }
}