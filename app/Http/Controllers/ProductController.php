<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            /**Create product when passed validation */
            $product = Product::create([
              'name' => $validate['name'],
              'description' => $validate['description'],
              'gender' => $validate['gender'],
              'origin' => $validate['origin'],
              'item_type_id' => $validate['item_type_id'],
            ]);
            /** Create new folder for images whether or not */
            $path = 'product_images/'.uniqid().'_'.$product->id;
            Storage::disk('public')->makeDirectory($path);
            if (Arr::exists($validate, 'product_images')) {
                $productImages = Arr::pull($validate, 'product_images');
                $imagesInstance = new ProductImage();
                $imagesInstance->insertSequenceFromProduct($productImages, $product->id);
                /*                 foreach ($productImages as $image) {
                                    $fileName = uniqid().'_'.$image->getClientOrginalName();

                                    $disk = Storage::disk('public');
                                    $disk->putFileAs($path, $image, $fileName);
                                    ProductImage::create([
                                      'path' => $path,
                                      'filename' => $fileName,
                                      'product_id' => $product->id
                                    ]);
                                } */
            }
            if (Arr::exists($validate, 'product_details')) {
                $productDetails = Arr::pull($validate, 'product_details');
                $pdInstance = new ProductDetail();
                $pdInstance->insertSequenceFromProduct($productDetails, $product->id);
                /* foreach ($productDetails as $pd) {
                    $pdInstance = ProductDetail::create([
                      'product_id' => $product->id,
                      'capacity_id' => $pd['id'],
                      'price' => $pd['price'],
                      'discount' => $pd['discount'],
                      'inventory' => $pd['inventory'],
                      'supplier' => $pd['supplier'],
                    ]);
                    if (Arr::exists($pd, 'collection')) {
                        $collection = Arr::pull($pd, 'collection');
                        foreach ($collection as $collect) {
                            $pdInstance->collections()->attach($collect['id']);
                        }
                    }
                } */
            }
            return $this->index();
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
