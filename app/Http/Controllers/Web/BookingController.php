<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $service)
    {
    }
}
