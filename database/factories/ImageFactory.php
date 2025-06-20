<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Image;

class ImageFactory extends Factory {
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'path' => fake()->word(),
            'alt' => fake()->word(),
        ];
    }
}
