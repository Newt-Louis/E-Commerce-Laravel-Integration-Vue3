<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Service\ProductService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with(['capacities','productImages','itemType'])->paginate(10);
        $collection = new ProductCollection($product);
        return $collection;
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
            /**
             * Create new folder for images when product adding don't include images
             * when use putFileAs() it will create new folder if directory don't have
             * specified folder to store.
             */
            if (Arr::exists($validate, 'product_images')) {
                $productImages = Arr::pull($validate, 'product_images');
                $imagesInstance = new ProductImage();
                $imagesInstance->insertSequenceFromProduct($productImages, $product->id);
            } else {
                $path = 'product_images/'.uniqid().'_'.$product->id;
                Storage::disk('public')->makeDirectory($path);
            }
            if (Arr::exists($validate, 'product_details')) {
                $productDetails = Arr::pull($validate, 'product_details');
                $pdInstance = new ProductDetail();
                $pdInstance->insertSequenceFromProduct($productDetails, $product->id);
            }
        });
        return response('Add new product done !');
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
