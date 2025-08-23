<?php

namespace App\Services;

use App\Models\CarType;

/**
 * Class CarTypeService.
 */
class CarTypeService
{
    public function getTypes()
    {
        return CarType::select('id', 'name')->get();
    }
}
