<?php

namespace Database\Seeders;

use App\Models\BrandModel;
use Illuminate\Database\Seeder;

class BrandModelSeeder extends Seeder {
    public function run(): void
    {
        BrandModel::factory()->count(5)->create();
    }
}
