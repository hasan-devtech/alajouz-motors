<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Renting;

class RentingFactory extends Factory {
    protected $model = Renting::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'car_id' => Car::factory(),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'total_price' => fake()->randomFloat(2, 0, 999999.99),
            'status' => fake()->randomElement(["placeholder"]),
            'license' => fake()->word(),
        ];
    }
}
