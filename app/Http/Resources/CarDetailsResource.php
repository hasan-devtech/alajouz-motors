<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailsResource extends JsonResource
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
            'brand_name' => $this->brand?->name,
            'brand_model_name' => $this->brandModel?->name,
            'car_type' => $this->carType?->name,
            'color' => $this->color?->name,
            'year' => $this->year,
            'price' => (float) $this->price,
            'distance' => (float) $this->distance,
            'engine' => $this->engine,
            'engine_type' => $this->engine_type,
            'vin' => $this->vin,
            'status' => $this->status,
            'images' => $this->images->map(function ($image) {
                return [
                    'path' => $image->path,
                    'alt' => $image->alt,
                ];
            }),
            'availability_schedule' => $this->availability_schedule,
        ];
    }
}
