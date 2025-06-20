<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\BrandModel;

class BrandModelFactory extends Factory {
    protected $model = BrandModel::class;

    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
        ];
    }
}
