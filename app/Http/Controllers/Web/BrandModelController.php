<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\BrandModelService;
use Illuminate\Http\Request;

class BrandModelController extends Controller
{
        public function __construct(private BrandModelService $service)
    {
    }
}
