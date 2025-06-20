<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $service)
    {
    }
}
