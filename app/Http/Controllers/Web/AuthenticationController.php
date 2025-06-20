<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct(private AuthenticationService $service)
    {
    }
}
