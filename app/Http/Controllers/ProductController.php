<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Log;

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
        Log::info($validate);
        Log::info(var_dump($request->input('product_details')[0], true));
        /** @var App\Models\Product $product */
        // $product = Product::create($validate);
        // if (isset($validate['product_details'])) {
        //     foreach ($validate['product_details'] as $pd) {
        //         $product->capacities()->attach($pd->id, [
        //           'price' => $pd->price,
        //             'discount' => $pd->discount,
        //             'inventory' => $pd->inventory,
        //              'supplier' => $pd->supplier,
        //         ]);
        //     }
        // }
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
