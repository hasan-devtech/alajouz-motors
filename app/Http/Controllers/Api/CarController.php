<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\GetCarsRequest;
use App\Http\Resources\CarResource;
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
}
