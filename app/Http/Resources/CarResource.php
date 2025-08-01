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
        // return [
        //     'id'            => $this->id,
        //     'brand_id'      => $this->brand_id,
        //     'brand_model_id'=> $this->brand_model_id,
        //     'color_id'      => $this->color_id,
        //     'year'          => $this->year,
        //     'distance'      => $this->distance,
        //     'engine'        => $this->engine,
        //     'engine_type'   => $this->engine_type,
        //     'price'         => $this->price,
        //     'vin'           => $this->vin,
        //     'type'          => $this->type,
        //     'status'        => $this->status,
        //     'images' => $this->images->map(function ($image) {
        //         return [
        //             'path' => $image->path,
        //             'alt'  => $image->alt,
        //         ];
        //     }),
        // ];
        $firstImage = $this->images()->first();
        return [
            'id'               => $this->id,
            'brand_name'       => $this->brand?->name,
            'brand_model_name' => $this->brandModel?->name,
            'year'             => $this->year,
            'price'            => (float) $this->price,
            'image'            => $firstImage ? [
                'path' => $firstImage->path,
                'alt'  => $firstImage->alt,
            ] : null,
        ];
    }
}
