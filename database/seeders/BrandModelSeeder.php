<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Database\Seeder;

class BrandModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'Toyota' => ['Corolla', 'Camry', 'Yaris'],
            'BMW' => ['X5', 'X3', '3 Series'],
            'Honda' => ['Civic', 'Accord', 'CR-V'],
            'Mercedes' => ['C-Class', 'E-Class', 'GLA'],
            'Ford' => ['Focus', 'Fusion', 'Mustang'],
        ];
        foreach ($models as $brandName => $carModels) {
            $brand = Brand::where('name', $brandName)->first();
            foreach ($carModels as $carModel) {
                BrandModel::create([
                    'brand_id' => $brand->id,
                    'name' => $carModel
                ]);
            }
        }
    }
}
