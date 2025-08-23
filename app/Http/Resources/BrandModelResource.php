<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandModelResource extends JsonResource
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
            //IS THIS IMPORTANT FOR  
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug
        ];
    }
}
