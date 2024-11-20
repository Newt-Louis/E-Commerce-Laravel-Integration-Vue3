<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function filterProduct($filteredArray)
    {
        $validFilters = [
          'collection' => 'filterByCollection',
          'capacity' => 'filterByCapacity',
          'category' => 'filterByCategory',
          'gender' => 'filterByGender',
          'origin' => 'filterByOrigin',
          'supplier' => 'filterBySupplier',
        ];
        $query = Product::query();
        foreach ($filteredArray as $key => $value) {
            if (($value !== '' && $value !== null) && isset($validFilters[$key])) {
                $methodName = $validFilters[$key];
                Log::info($value !== null);
                $this->$methodName($query, $value);
            }
        }
        return $query;
    }
    public function filterByGender(Builder $query, $value)
    {
        $query->where('gender', '=', $value);
        return $query;
    }
    public function filterByOrigin(Builder $query, $value)
    {
        $query->where('origin', '=', $value);
        return $query;
    }
    public function filterBySupplier(Builder $query, $value)
    {
        $query->whereHas('capacities', function (Builder $subquery) use ($value) {
            $subquery->where('supplier', '=', $value);
        });
        return $query;
    }
    public function filterByCapacity(Builder $query, $id)
    {
        $query->whereHas('capacities', function (Builder $subquery) use ($id) {
            $subquery->where('capacities.id', '=', $id);
        });
        return $query;
    }
    public function filterByCateGory(Builder $query, $id)
    {
        $query->whereHas('itemType', function (Builder $subquery) use ($id) {
            $subquery->where('item_types.id', '=', $id);
        });
        return $query;
    }
    public function filterByCollection(Builder $query, $id)
    {
        $query->whereHas('collectionProductDetail', function (Builder $subquery) use ($id) {
            $subquery->where('collection_id', '=', $id);
        });
        return $query;
    }
}
