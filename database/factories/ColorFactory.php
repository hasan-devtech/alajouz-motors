<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Color;

class ColorFactory extends Factory {
    protected $model = Color::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
