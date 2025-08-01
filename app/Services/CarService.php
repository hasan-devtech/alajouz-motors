<?php

namespace App\Services;

use App\Models\Car;
use function App\Helpers\resolvePerPage;

class CarService
{
    public function getCars(array $filters)
    {
        $perPage = resolvePerPage($filters['per_page'] ?? null);
        return Car::with(['brand', 'brandModel', 'color','images'])
        ->filter( $filters)
        ->paginate($perPage);
    }

}
