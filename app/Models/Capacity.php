<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Capacity extends Model
{
    use HasFactory;

    protected $fillable = ['name','volume'];

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetail::class);
    }
}
