<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Car;
use App\Models\CarType;
use App\Models\Color;
use App\Models\Customer;
use App\Models\SellingRequest;
use Illuminate\Database\Seeder;
use App\Enums\RequestStatusEnum;
use App\Enums\CarEngineTypeEnum;
use App\Enums\CarListingTypeEnum;
use App\Enums\CarStatusEnum;
use App\Enums\CarTypeEnum;

class SellingRequestSeeder extends Seeder
{
    public function run(): void
    {
        $engineTypes = CarEngineTypeEnum::cases();
        $statuses = RequestStatusEnum::cases();
        $listingMood = CarListingTypeEnum::Sale;
        $carTypes = CarType::pluck('id')->toArray();
        $brands = Brand::pluck('id')->toArray();
        $brandModels = BrandModel::pluck('id')->toArray();
        $colors = Color::pluck('id')->toArray();
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $status = $statuses[array_rand($statuses)];
            $car = Car::create([
                'brand_id' => $brands[array_rand($brands)],
                'brand_model_id' => $brandModels[array_rand($brandModels)],
                'car_type_id' => $carTypes[array_rand($carTypes)],
                'color_id' => $colors[array_rand($colors)],
                'year' => rand(2000, 2025),
                'distance' => rand(0, 300000),
                'engine' => rand(1000, 5000),
                'engine_type' => $engineTypes[array_rand($engineTypes)],
                'vin' => strtoupper(uniqid('VIN')),
                'mood' => $listingMood,
            ]);
            SellingRequest::create([
                'car_id' => $car->id,
                'customer_id' => $customer->id,
                'price' => rand(5000, 50000),
                'status' => $status,
            ]);
        }
    }
}
