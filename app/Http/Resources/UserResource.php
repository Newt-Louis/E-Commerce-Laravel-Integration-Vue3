<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
          'email' => $this->email,
          'email_verified_at' => $this->email_verified_at,
          'phone' => $this->phone,
          'role_id' => $this->role_id,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'role' => $this->role,
          'avatar' => $this->avatar ? Storage::url($this->avatar->path) : null,
        ];
    }
}
