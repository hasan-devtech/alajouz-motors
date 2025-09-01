<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(BrandSeeder::class);
        $this->call(BrandModelSeeder::class);
        $this->call(CarTypeSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(RentingSeeder::class);
        $this->call(UserActivitySeeder::class);
        $this->call(SellingRequestSeeder::class);
    }
}
