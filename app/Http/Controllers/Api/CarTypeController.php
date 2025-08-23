<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CarTypeService;
use Illuminate\Http\Request;
use function App\Helpers\sendResponseHelper;

class CarTypeController extends Controller
{
    public function __construct(private CarTypeService $service){}
    public function getTypes(){
        $types = $this->service->getTypes();
        return sendResponseHelper(data:$types);
    }
}
