<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function __construct(private ColorService $service)
    {
    }
}
