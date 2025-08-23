<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;

class CustomerFactory extends Factory {
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName, 
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->generateSyrianPhoneNumber(),
            'is_verified' => $this->faker->boolean(),
            'password' => 'h123456789H',
        ];
    }

    private function generateSyrianPhoneNumber()
    {
        $prefix = $this->faker->randomElement(['09', '+963']);
        $number = '';
        for ($i = 0; $i < 8; $i++) {
            $number .= $this->faker->numberBetween(3, 9);
        }
        return $prefix . $number;
    }
}
