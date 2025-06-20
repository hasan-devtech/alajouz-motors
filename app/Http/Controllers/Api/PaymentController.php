<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $service)
    {
    }
}
