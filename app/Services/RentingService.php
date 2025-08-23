<?php

namespace App\Services;

use App\Enums\RequestStatusEnum;
use App\Models\Car;
use App\Models\Renting;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
use Throwable;
use function App\Helpers\resolvePerPage;

class RentingService
{
    public function handleCreateRental($data)
    {
        $car = Car::find($data['car_id']);
        if (!$car || !$car->isAvailableForRent()) {
            return [
                'status' => false,
                'message' => 'The specific car is not available for rent'
            ];
        }
        if (!$car->isAvailableForPeriod($data['start_date'], $data['end_date'])) {
            return [
                'status' => false,
                'message' => 'The specific period is not available for rent'
            ];
        }
        $data['total_price'] = $car->price * $data['rental_days'];
        try {
            DB::transaction(function () use ($data) {
                $licensePath = $data['license']->store('licenses', 'local');
                $data['license'] = $licensePath;
                Renting::create($data);
            });
            return [
                'status' => true,
                'message' => 'Rented request created successfully'
            ];
        } catch (Throwable $e) {
            Log::error('Failed to create renting record', ['error' => $e->getMessage(), 'data' => $data]);
            return ['status' => false, 'message' => 'An error occurred while processing the rental'];
        }
    }
    public function handleEditRental()
    {

    }


    private function updateStatus($renting, $status)
    {
        $allowedTransitions = [
            RequestStatusEnum::Pending->value => [RequestStatusEnum::Approved->value, RequestStatusEnum::Cancelled->value],
            RequestStatusEnum::Approved->value => [RequestStatusEnum::Completed->value, RequestStatusEnum::Cancelled->value],
            RequestStatusEnum::Cancelled->value => [],
            RequestStatusEnum::Completed->value => [],
        ];
        $current = $renting->status;
        if (!in_array($status, $allowedTransitions[$current] ?? [])) {
            return false;
        }
        return $renting->update(['status' => $status]);
    }

    public function getUserRentings($user)
    {
        $perPage = resolvePerPage(request()->input('per_page') ?? null);
        return  $user->rentings()
            ->with(['car', 'car.brand', 'car.brandModel', 'car.carType'])
            ->paginate($perPage);
    }

}
