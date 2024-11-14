<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['path','filename','product_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** @param \Illuminate\Http\UploadedFile[] $data */
    public function insertSequenceFromProduct(array $data, $id)
    {
        /** Create new folder for images whether or not */
        $path = 'product_images/'.uniqid().'_'.$id;
        Storage::disk('public')->makeDirectory($path);
        foreach ($data as $image) {
            $fileName = uniqid().'_'.$image->getClientOrginalName();
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('public');
            $disk->putFileAs($path, $image, $fileName);
            $this->create([
              'path' => $path,
              'filename' => $fileName,
              'product_id' => $id
            ]);
        }
    }
}
