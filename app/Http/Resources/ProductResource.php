<?php

namespace App\Http\Resources;

use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'description' => $this->description,
          'gender' => $this->gender,
          'origin' => $this->origin,
          'views' => $this->views,
          'item_type_id' => $this->item_type_id,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'deleted_at' => $this->deleted_at,
          'capacities' => $this->capacities->map(function ($capacity) {
              $capacityArray = $capacity->toArray();
              $pivot = ProductDetail::where('capacity_id', $capacityArray['id'])->where('product_id', $this->id)->get();
              $pivot->load('collections');
              $capacityArray['pivot'] = $pivot;
              return $capacityArray;
          }),
          'product_images' => $this->productImages,
        ];
    }
}
