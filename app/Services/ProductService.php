<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function filter()
    {
        $query = Product::with(['capacities','productImages'])->query();
    }
    public function filterByGender(Builder $query, $value)
    {
        if ($value) {
            $query->where('gender', '=', $value);
        }
        return $query;
    }
}
