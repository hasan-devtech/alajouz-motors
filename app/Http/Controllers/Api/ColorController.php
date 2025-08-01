<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\ColorService;
use Illuminate\Http\Request;
use function App\Helpers\sendResponseHelper;

class ColorController extends Controller
{
    public function __construct(private ColorService $service)
    {
    }
    public function getColors()
    {
        $colors = $this->service->getColors();
        return sendResponseHelper(data: $colors);
    }
}
