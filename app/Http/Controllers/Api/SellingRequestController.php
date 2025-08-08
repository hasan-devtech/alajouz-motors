<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\SellingCarRequest;
use App\Services\SellingRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use function App\Helpers\sendResponseHelper;

class SellingRequestController extends Controller
{
    public function __construct(private SellingRequestService $service)
    {
    }
    public function create(SellingCarRequest $request)
    {
        $success = $this->service->handleCreate($request->validated(), $request->user()->id);
        return $success
            ? sendResponseHelper(201, 'Selling request created successfully')
            : sendResponseHelper(500, 'Failed to create selling request');
    }

    public function edit(SellingCarRequest $request)
    {
        $success = $this->service->handleEdit($request->selling_request_id, $request->user()->id, $request->validated());
        return $success
            ? sendResponseHelper(200, 'Selling request updated successfully')
            : sendResponseHelper(400, 'Failed to update selling request');
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'selling_request_id' => [
                'required',
                'integer',
            ]
        ]);
        $success = $this->service->handleCancel($request->selling_request_id, $request->user()->id);
        return $success
            ? sendResponseHelper(200, 'Selling request canceled successfully')
            : sendResponseHelper(400, 'Selling request cancelled faild');
    }

}
