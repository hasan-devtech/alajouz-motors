<?php

namespace App\Services;

use App\Http\Resources\CarResource;
use App\Models\Car;
use function App\Helpers\resolvePerPage;

class CustomerService
{
    public function handleAddFavorite($car_id, $customer)
    {
        $car = Car::find($car_id);
        if (!$car || !$car->visible()) {
            return [
                'status' => false,
                'message' => 'Car cannot be added to favorites due to its status'
            ];
        }
        $alreadyFavorite = $customer->favorites()->where('car_id', $car_id)->exists();
        if ($alreadyFavorite) {
            return
                [
                    'status' => true,
                    'message' => 'Car is already in your favorites'
                ];
        }
        $customer->favorites()->attach($car_id);
        return [
            'status' => true,
            'message' => 'Car added to your favorites successfully'
        ];
    }

    public function handleRemoveFavorite($car_id, $customer)
    {
        $exists = $customer->favorites()->where('car_id', $car_id)->exists();
        if (!$exists) {
            return false;
        }
        return (bool) $customer->favorites()->detach($car_id);
    }

    public function handleGetFavorites($user)
    {
        $perPage = resolvePerPage(request()->input('per_page') ?? null);
        $favorites = $user->favorites()->with(['brand', 'brandModel', 'color', 'images', 'carType']);
        return CarResource::collection($favorites->paginate($perPage)->withQueryString());
    }
}
