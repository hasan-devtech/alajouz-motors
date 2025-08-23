<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\GetCarsRequest;
use App\Http\Resources\CarDetailsResource;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\Request;
use function App\Helpers\paginationResponseHelper;
use function App\Helpers\sendResponseHelper;

class CarController extends Controller
{
    public function __construct(private CarService $service)
    {
    }
    public function getCars(GetCarsRequest $request)
    {
        $cars = $this->service->getCars($request->validated());
        return paginationResponseHelper(data: CarResource::collection($cars));
    }
    public function getCarDetails(Request $request)
    {
        $request->validate(['car_id' => ['required', 'integer']]);
        $car = $this->service->getCarDetails($request->car_id);
        if (!$car) {
            return sendResponseHelper(400, "Invalid Process");
        }
        return sendResponseHelper(
            200,
            'Car details retrieved successfully',
            CarDetailsResource::make($car)
        );
    }
}
