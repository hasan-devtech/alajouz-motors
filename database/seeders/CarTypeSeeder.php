<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'sedan',
            'hatchback',
            'suv',        
            'crossover',   
            'convertible', 
            'coupe',
            'minivan',     
            'van',
            'pickup',     
            'truck',
            'wagon',
        ];
        foreach ($types as $type) {
            CarType::create(['name' => $type]);
        }
    }
}
