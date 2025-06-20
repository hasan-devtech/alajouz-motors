<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Car;
use App\Models\Color;

class CarFactory extends Factory {
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'brand_model_id' => BrandModel::factory(),
            'color_id' => Color::factory(),
            'year' => fake()->dateTime(),
            'distance' => fake()->randomFloat(2, 0, 999999.99),
            'engine' => fake()->numberBetween(-10000, 10000),
            'engine_type' => fake()->randomElement(["placeholder"]),
            'price' => fake()->randomFloat(2, 0, 999999.99),
            'vin' => fake()->word(),
            'type' => fake()->randomElement(["placeholder"]),
            'status' => fake()->randomElement(["placeholder"]),
        ];
    }
}
