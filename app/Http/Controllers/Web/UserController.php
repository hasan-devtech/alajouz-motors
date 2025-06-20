<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }
}
