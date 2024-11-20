<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionProductDetail extends Model
{
    use HasFactory;

    protected $table = 'collection_product_detail';
    protected $fillable = ['product_id','capacity_id','collection_id'];


}
