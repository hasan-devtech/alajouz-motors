<?php

namespace App\Services;

use App\Enums\CarStatusEnum;
use App\Models\Car;
use function App\Helpers\resolvePerPage;

class CarService
{
    public function getCars(array $filters)
    {
        $perPage = resolvePerPage($filters['per_page'] ?? null);
        $filters['status'] = [CarStatusEnum::Available, CarStatusEnum::Rented];
        return Car::with(['brand', 'brandModel', 'color', 'images', 'CarType'])
            ->filter($filters)
            ->paginate($perPage);
    }
    public function getCarDetails(int $carId)
    {
        $car = Car::with(['brand', 'brandModel', 'carType', 'images'])
            ->find($carId);
        if (!$car || !$car->isRentOrAvailable()) {
            return false;
        }
        return $car;
    }

}
