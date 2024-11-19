<?php

namespace App\Http\Resources;

use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productImages = [];
        if (count($this->productImages) > 0) {
            foreach ($this->productImages as $image) {
                $imageArray = $image->toArray();
                $fullPath = $imageArray['path'].'/'.$imageArray['filename'];
                $imageArray = Arr::except($imageArray, ['path','filename']);
                $imageArray = Arr::add($imageArray, 'fullpath', Storage::disk('local')->url($fullPath));
                $productImages[] = $imageArray;
            }
        }
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
          'item_type' => $this->itemType,
          'capacities' => $this->capacities->map(function ($capacity) {
              $capacityArray = $capacity->toArray();
              $pivot = ProductDetail::where('capacity_id', $capacityArray['id'])->where('product_id', $this->id)->get();
              $pivot->load('collections');
              $capacityArray['pivot'] = $pivot[0];
              return $capacityArray;
          }),
          'product_images' => $productImages,
        ];
    }
}
