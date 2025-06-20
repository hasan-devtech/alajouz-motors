<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserActivity;

class UserActivityFactory extends Factory {
    protected $model = UserActivity::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'checked_in' => fake()->dateTime(),
            'checked_out' => fake()->dateTime(),
            'status' => fake()->randomElement(["placeholder"]),
            'notes' => fake()->text(),
        ];
    }
}
