<?php

namespace App\Services;

use App\Enums\RequestStatusEnum;
use App\Models\Customer;
use App\Models\SellingRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class SellingRequestService
{
    public function __construct(private ImageService $imageService)
    {
    }
    public function create($data, $customer)
    {
        $images = $data['car_images'];
        $data['price_after_commission'] = $data['price'];
        unset($data['car_images']);
        $data['customer_id'] = $customer->id;
        try {
            $sellingRequest = SellingRequest::create($data);
            $this->imageService->storeImages($images, $sellingRequest);
            return true;
        } catch (Exception $e) {
            Log::error('Creating selling request failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
