<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function getBrands($brandName = null)
    {
        $query = Brand::query();
        if (!empty($brandName)) {
            $query->where('name', "LIKE", "%" . $brandName . "%");
        }
        return $query->get();
    }
}
