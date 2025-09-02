<?php

namespace Database\Seeders;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => "omar",
            'last_name' => "omar",
            'email' => "omar@gmail.com",
            'phone' => "+963999999999",
            'hired_date' => now()->subYears(2),
            'salary' => random_int(3000, 10000),
            'status' => UserStatusEnum::Active->value,
            'password' => 'h123456789H',
        ]);
        User::factory()->count(10)->create();
    }
}
