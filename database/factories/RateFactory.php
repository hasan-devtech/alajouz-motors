<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Rate;
use App\Models\Renting;

class RateFactory extends Factory {
    protected $model = Rate::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'car_id' => Car::factory(),
            'renting_id' => Renting::factory(),
            'rate' => fake()->numberBetween(-1000, 1000),
            'comment' => fake()->text(),
        ];
    }
}
