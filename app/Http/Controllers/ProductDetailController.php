<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductDetailController extends Controller
{
    public function supplierIndex()
    {
        $supplier = ProductDetail::select('supplier')->get()->toArray();
        $result = Arr::pluck($supplier, 'supplier');
        return response()->json($result);
    }
}
