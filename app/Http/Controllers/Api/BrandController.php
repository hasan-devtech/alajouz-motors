<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(private BrandService $service)
    {
    }
}
