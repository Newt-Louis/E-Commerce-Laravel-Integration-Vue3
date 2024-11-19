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
    public function filter(Request $request)
    {
        $query = Product::with(['capacities','productImages'])->query();
        if ($request->gender !== null || $request->gender !== '') {
            $this->filterByGender($query, $request->gender);
        }
    }
    public function filterByGender(Builder $query, $value)
    {
        if ($value) {
            $query->where('gender', '=', $value);
        }
        return $query;
    }
    public function filterBySupplier(Builder $query, $value)
    {
        $query->join('product_details', 'product_id', '=');
    }
}
