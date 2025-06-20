<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\RateService;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function __construct(private RateService $service)
    {
    }
}
