<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_at','end_at'];


    /**
     *
     * Accessor & Mutators
     *
     * */

    protected function startAt(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Carbon::parse($value),
        );
    }
    protected function endAt(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Carbon::parse($value),
        );
    }
}
