<?php

namespace Database\Seeders;

use App\Enums\CarEngineTypeEnum;
use App\Enums\CarListingTypeEnum;
use App\Enums\CarStatusEnum;
use App\Enums\CarTypeEnum;
use App\Models\Car;
use App\Models\CarType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $imagePaths = collect(range(1, 10))->map(fn($i) => "images/cars/sample{$i}.jpg");
        $carMood = CarListingTypeEnum::cases();
        $engineTypes = CarEngineTypeEnum::cases();
        $statuses = CarStatusEnum::cases();
        $types = CarType::pluck('id')->toArray();
        $brandModels = [
            1 => [1, 2, 3],
            9 => [4, 5, 6],
            4 => [7, 8, 9],
            11 => [10, 11, 12],
            7 => [13, 14, 15]
        ];
        foreach ($brandModels as $brandId => $modelIds) {
            for ($i = 0; $i < 10; $i++) {
                $cars[] = Car::create([
                    'brand_id' => $brandId,
                    'brand_model_id' => $modelIds[array_rand($modelIds)],
                    'car_type_id' => $types[array_rand($types)],
                    'color_id' => rand(1, 11),
                    'year' => rand(2000, 2025),
                    'distance' => round(rand(5000, 120000) + mt_rand() / mt_getrandmax(), 2),
                    'engine' => rand(1200, 3500),
                    'engine_type' => $engineTypes[array_rand($engineTypes)]->value,
                    'price' => round(rand(5000, 80000) + mt_rand() / mt_getrandmax(), 2),
                    'vin' => strtoupper(Str::random(17)),
                    'mood' => $carMood[array_rand($carMood)]->value,
                    'status' => $statuses[array_rand($statuses)]->value,
                ]);
            }
        }
        foreach ($cars as $car) {
            foreach ($imagePaths as $path) {
                $car->images()->create([
                    'path' => $path,
                    'alt' => 'Car image for car #' . $car->id,
                ]);
            }
        }
    }
}
