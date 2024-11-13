<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validate = $request->validated();
        /** @var App\Models\Product $product */

        DB::transaction(function () use ($validate) {
            if (Arr::exists($validate, 'product_details')) {
                $productDetails = Arr::pull($validate, 'product_details');
                $product = Product::create($validate);
                Log::info($productDetails);
                foreach ($productDetails as $pd) {
                    if (Arr::exists($pd, 'collection')) {
                        $collection = Arr::pull($pd, 'collection');
                        $pdInstance = ProductDetail::create([
                          'product_id' => $product->id,
                          'capacity_id' => $pd['id'],
                          'price' => $pd['price'],
                          'discount' => $pd['discount'],
                          'inventory' => $pd['inventory'],
                          'supplier' => $pd['supplier'],
                        ]);
                        foreach ($collection as $collect) {
                            $pdInstance->collections()->attach($collect['id']);
                        }
                    } else {
                        ProductDetail::create([
                          'product_id' => $product->id,
                          'capacity_id' => $pd['id'],
                          'price' => $pd['price'],
                          'discount' => $pd['discount'],
                          'inventory' => $pd['inventory'],
                          'supplier' => $pd['supplier'],
                        ]);
                    }
                }
            } else {
                $product = Product::create($validate);
            }
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
