<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(private BrandService $service)
    {
    }
}
