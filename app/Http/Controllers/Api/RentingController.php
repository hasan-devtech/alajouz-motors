<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\RentRequest;
use App\Http\Resources\RentingResource;
use App\Services\RentingService;
use Illuminate\Http\Request;
use function App\Helpers\paginationResponseHelper;
use function App\Helpers\sendResponseHelper;

class RentingController extends Controller
{
    public function __construct(private RentingService $service)
    {
    }
    public function create(RentRequest $request)
    {
        $validated = $request->validated();
        $validated['customer_id'] = $request->user()->id;
        $validated['rental_days'] = $request->rental_days;
        $result = $this->service->handleCreateRental($validated);
        return $result['status'] ?
            sendResponseHelper(201, $result['message']) :
            sendResponseHelper(422, $result['message']);
    }
    public function getRentingsHistory()
    {
        $rentings = $this->service->getUserRentings(request()->user());
        return paginationResponseHelper(
            200,
            'Rentings history retrieved successfully',
            RentingResource::collection($rentings)
        );
    }

    // public function edit(RentRequest $request){
    //     $validated = $request->validated();
    //     $result = $this->service->handleEditRental()
    // }
}
