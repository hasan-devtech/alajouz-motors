<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(private CarService $service)
    {
    }
}
