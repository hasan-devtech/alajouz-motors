<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\RentingService;
use Illuminate\Http\Request;

class RentingController extends Controller
{
    public function __construct(private RentingService $service)
    {
    }
}
