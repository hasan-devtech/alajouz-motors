<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\SellingRequestService;
use Illuminate\Http\Request;

class SellingRequestController extends Controller
{
    public function __construct(private SellingRequestService $service)
    {
    }
}
