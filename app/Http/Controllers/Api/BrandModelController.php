<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\BrandModelResource;
use App\Services\BrandModelService;
use Illuminate\Http\Request;
use function App\Helpers\PaginationResponseHelper;

class BrandModelController extends Controller
{
    public function __construct(private BrandModelService $service)
    {
    }

    public function getModels(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:126',
            'per_page' => 'nullable|integer'
        ]);
        $models = $this->service->getModels($validated);
        return paginationResponseHelper(data: BrandModelResource::collection($models));
    }

    public function getModelsByBrand(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|numeric|exists:brands,id',
            'per_page' => 'nullable|integer'
        ]);
        $modelsByBrand = $this->service->getModels($validated);
        return paginationResponseHelper(data: BrandModelResource::collection($modelsByBrand));
    }
}
