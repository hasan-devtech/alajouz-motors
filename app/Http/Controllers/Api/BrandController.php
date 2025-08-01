<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\BrandResource;
use App\Services\BrandService;
use Illuminate\Http\Request;
use function App\Helpers\sendResponseHelper;

class BrandController extends Controller
{
    public function __construct(private BrandService $service)
    {
    }

    public function getBrands(Request $request)
    {
        $validated = $request->validate([
            'name' => "string|max:126|nullable"
        ]);
        $brands = $this->service->getBrands($validated['name'] ?? null);
        return sendResponseHelper(data: BrandResource::collection($brands));
    }
}
