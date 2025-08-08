<?php

namespace App\Services;

use App\Enums\RequestStatusEnum;
use App\Models\SellingRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SellingRequestService
{
    public function __construct(private ImageService $imageService)
    {
    }
    public function handleCreate($data, $customer_id)
    {
        $images = $data['car_images'];
        unset($data['car_images']);
        $data['customer_id'] = $customer_id;
        try {
            $sellingRequest = SellingRequest::create($data);
            $this->imageService->storeImages($images, $sellingRequest);
            return true;
        } catch (Exception $e) {
            Log::error('Creating selling request failed', ['error' => $e->getMessage()]);
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
            if (isset($data['car_images'])) {
                $images = $data['car_images'];
                unset($data['car_images']);
                DB::transaction(function () use ($sellingRequest, $data, $images) {
                    $this->imageService->deleteModelImages($sellingRequest);
                    $this->imageService->storeImages($images, $sellingRequest);
                    $sellingRequest->update($data);
                });
            } else {
                $sellingRequest->update($data);
            }
            return true;
        } catch (Exception $e) {
            Log::error('Edit selling request failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
    public function handleCancel($id, $customerId): bool
    {
        $sellingRequest = SellingRequest::where('id', $id)
            ->where('customer_id', $customerId)
            ->first();
        if (!$sellingRequest || !$sellingRequest->isPending() || $sellingRequest->isCancelled()) {
            return false;
        }
        return $sellingRequest->update([
            'status' => RequestStatusEnum::Cancelled->value
        ]);
    }


}
