<?php
namespace App\Services;

use App\Models\BrandModel;
use function App\Helpers\resolvePerPage;

class BrandModelService
{
    public function getModels(array $filter)
    {
        $perPage = resolvePerPage($filter['per_page'] ?? null);
        $query = BrandModel::query();
        if (!empty($filter['brand_id'])) {
            $query->where('brand_id', $filter['brand_id']);
        }
        if (!empty($filter['name'])) {
            $query->where('name', 'LIKE', '%' . $filter['name'] . '%');
        }
        return $query
            ->select('id', 'name', 'slug', 'brand_id')
            ->paginate($perPage)
            ->withQueryString();
    }
}
