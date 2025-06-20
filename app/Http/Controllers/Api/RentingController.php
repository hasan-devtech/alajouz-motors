<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\RentingService;
use Illuminate\Http\Request;

class RentingController extends Controller
{
    public function __construct(private RentingService $service)
    {
    }
}
