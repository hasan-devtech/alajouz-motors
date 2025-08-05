<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\SellingCarRequest;
use App\Services\SellingRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function App\Helpers\sendResponseHelper;

class SellingRequestController extends Controller
{
    public function __construct(private SellingRequestService $service)
    {
    }
    public function createSellingRequest(SellingCarRequest $request)
    {
        $success = $this->service->create($request->validated(), request()->user());
        if (!$success) {
            return sendResponseHelper(500, 'Failed to create selling request');
        }
        return sendResponseHelper(201, 'Selling request created successfully');
    }

    public function edit($id, SellingCarRequest $request)
    {
        try {
            $customer = auth('customer')->user();
            $success = $this->service->editSellingRequest($id, $request->validated(), $customer);
            if (!$success) {
                return sendResponseHelper(404, 'Selling request not found or update failed');
            }
            return sendResponseHelper(200, 'Selling request updated successfully');
        } catch (\Throwable $th) {
            Log::error('Selling request update error', ['error' => $th->getMessage()]);
            return sendResponseHelper(500, 'An error occurred');
        }
    }

    public function cancel()
    {
        try {
            $customer = auth('customer')->user();
            $success = $this->service->cancelSellingRequest($id, $customer);
            if (!$success) {
                return sendResponseHelper(404, 'Selling request not found or cancel failed');
            }
            return sendResponseHelper(200, 'Selling request cancelled successfully');
        } catch (\Throwable $th) {
            Log::error('Selling request cancel error', ['error' => $th->getMessage()]);
            return sendResponseHelper(500, 'An error occurred');
        }
    }

}
