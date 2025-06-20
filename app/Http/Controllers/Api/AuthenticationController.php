<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct(private AuthenticationService $service)
    {
    }
}
