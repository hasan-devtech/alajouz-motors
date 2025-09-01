<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstImage = $this->images()->first();
        return [
            'id' => $this->id,
            'mood' => $this->mood,
            'brand_name' => $this->brand?->name,
            'brand_model_name' => $this->brandModel?->name,
            'car_type' => $this->carType?->name,
            'year' => $this->year,
            'price' => (float) $this->price,
            'image' => $firstImage ? [
                'path' => $firstImage->path,
                'alt' => $firstImage->alt,
            ] : null,
        ];
    }
}
