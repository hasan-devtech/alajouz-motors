<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $service)
    {
    }
}
