<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\OTP;

class OTPFactory extends Factory {
    protected $model = OTP::class;

    public function definition(): array
    {
        return [
            'code' => fake()->word(),
            'request_code' => fake()->word(),
            'phone' => fake()->phoneNumber(),
            'type' => fake()->randomElement(["placeholder"]),
        ];
    }
}
