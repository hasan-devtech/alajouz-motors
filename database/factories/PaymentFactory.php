<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payment;

class PaymentFactory extends Factory {
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'method' => fake()->randomElement(["placeholder"]),
            'amount' => fake()->randomFloat(2, 0, 999999.99),
            'payment_date' => fake()->dateTime(),
            'status' => fake()->randomElement(["placeholder"]),
        ];
    }
}
