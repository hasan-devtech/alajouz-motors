<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\UserActivityService;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function __construct(private UserActivityService $service)
    {
    }
}
