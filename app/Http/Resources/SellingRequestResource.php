<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellingRequestResource extends JsonResource
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
            'mood' => $this->car->mood,
            'brand_name' => $this->car->brand?->name,
            'brand_model_name' => $this->car->brandModel?->name,
            'car_type' => $this->car->carType?->name,
            'color' => $this->car->color?->name,
            'year' => $this->car->year,
            'price' => (float) $this->price,
            'distance' => (float) $this->car->distance,
            'engine' => $this->car->engine,
            'engine_type' => $this->car->engine_type,
            'vin' => $this->car->vin,
            'status' => $this->status,
            'images' => $this->car->images->map(function ($image) {
                return [
                    'path' => $image->path,
                    'alt' => $image->alt,
                    'id' => $image->id
                ];
            }),
        ];
    }
}
