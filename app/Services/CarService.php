<?php

namespace App\Services;

use App\Enums\CarStatusEnum;
use App\Enums\RequestStatusEnum;
use App\Models\Car;
use App\Models\SellingRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use function App\Helpers\resolvePerPage;

class CarService
{
    public function getCars(array $filters)
    {
        $perPage = resolvePerPage($filters['per_page'] ?? null);
        return Car::visible()->with(['brand', 'brandModel', 'color', 'images', 'carType', 'sellingRequest'])
            ->filter($filters)  
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getCarDetails($carId)
    {
        $car = Car::with(['brand', 'brandModel', 'carType', 'images'])
            ->find($carId);
        if (!$car || !$car->isVisible()) {
            return false;
        }
        return $car;
    }

}
