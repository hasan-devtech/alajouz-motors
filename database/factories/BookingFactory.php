<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;

class BookingFactory extends Factory {
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'car_id' => Car::factory(),
            'amount' => fake()->randomFloat(2, 0, 999999.99),
            'visit_date' => fake()->dateTime(),
            'status' => fake()->randomElement(["placeholder"]),
        ];
    }
}
