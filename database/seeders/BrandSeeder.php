<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Toyota',
            'Hyundai',
            'Kia',
            'Honda',
            'Nissan',
            'Mazda',
            'Ford',
            'Chevrolet',
            'BMW',
            'Mercedes-Benz',
            'Mercedes',
            'Audi',
            'Volkswagen',
            'Peugeot',
            'Renault',
            'Fiat',
            'Jeep',
            'Dodge',
            'Subaru',
            'Volvo',
            'Tesla',
        ];
        foreach ($brands as $name) {
            Brand::create(["name" => $name]);
        }
    }
}
