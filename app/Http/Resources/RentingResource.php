<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentingResource extends JsonResource
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
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'total_price' => (float) $this->total_price,
            'rental_days' => $this?->rental_days,
            'status' => $this->status,
            'license' => $this->license,
            'car' => CarResource::make($this->whenLoaded('car')),
        ];
    }
}
