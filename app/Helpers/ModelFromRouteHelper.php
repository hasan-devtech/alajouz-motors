<?php
namespace App\Helpers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
function getModelsFromRoute(Request $request)
{
    return $request->routeIs('customer.*') ? Customer::class : User::class;
}