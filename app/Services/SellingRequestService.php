<?php

namespace App\Services;

use App\Enums\CarListingTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Models\Car;
use App\Models\SellingRequest;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function App\Helpers\resolvePerPage;

class SellingRequestService
{
    public function __construct(private ImageService $imageService)
    {
    }
    public function handleCreate($data, $customer_id)
    {
        try {
            DB::transaction(function () use ($data, $customer_id) {
                $carFields = ['brand_id', 'brand_model_id', 'car_type_id', 'color_id', 'distance', 'engine', 'engine_type', 'year', 'vin'];
                $carData = Arr::only($data, $carFields);
                $carData['mood'] = CarListingTypeEnum::Sale;
                $car = Car::create($carData);
                $requestFields = ['price'];
                $sellingRequestData = Arr::only($data, $requestFields);
                $sellingRequestData['customer_id'] = $customer_id;
                $sellingRequestData['car_id'] = $car->id;
                SellingRequest::create($sellingRequestData);
                if (!empty($data['car_images'])) {
                    $this->imageService->storeImages($data['car_images'], $car);
                }
            });
            return true;
        } catch (\Exception $e) {
            Log::error('Creating selling request failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

    public function handleEdit($id, $customer_id, $data)
    {
        $sellingRequest = SellingRequest::where('id', $id)
            ->where('customer_id', $customer_id)
            ->first();
        if (!$sellingRequest || !$sellingRequest->isPending()) {
            return false;
        }
        try {
            DB::transaction(function () use ($sellingRequest, $data) {
                $car = $sellingRequest->car;
                if (!empty($data['new_car_images'])) {
                    $this->imageService->storeImages($data['new_car_images'], $car);
                }
                if (!empty($data['delete_image_ids'])) {
                    $this->imageService->deleteImagesByIds($data['delete_image_ids'], $car);
                }
                $carFields = ['brand_id', 'brand_model_id', 'car_type_id', 'color_id', 'distance', 'engine', 'engine_type', 'year', 'vin'];
                $carUpdateData = Arr::only($data, $carFields);
                if (!empty($carUpdateData)) {
                    $car->update($carUpdateData);
                }
                $requestFields = ['price'];
                $requestUpdateData = Arr::only($data, $requestFields);
                if (!empty($requestUpdateData)) {
                    $sellingRequest->update($requestUpdateData);
                }
            });
            return $sellingRequest->fresh(['car', 'car.images']);
        } catch (Exception $e) {
            Log::error('Edit selling request failed', ['error' => $e->getMessage()]);
            return false;
        }
    }


    public function handleCancel($id, $customerId)
    {
        try {
            $sellingRequest = SellingRequest::where('id', $id)
                ->where('customer_id', $customerId)
                ->first();
            if (!$sellingRequest || !$sellingRequest->isPending()) {
                return false;
            }
            $sellingRequest->status = RequestStatusEnum::Cancelled;
            $sellingRequest->save();
            return true;
        } catch (\Exception $e) {
            Log::error('Cancelling selling request failed', [
                'id' => $id,
                'customer_id' => $customerId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function getCustomerSellingRequests($customerId)
    {
        $perPage = resolvePerPage($filters['per_page'] ?? null);
        return SellingRequest::with('car.brand', 'car.brandModel', 'car.color', 'car.images', 'car.carType')
            ->where('customer_id', $customerId)
            ->paginate($perPage)
            ->withQueryString();
    }



}
