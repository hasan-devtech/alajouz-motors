<?php

namespace App\Http\Controllers\Api;

use App\Enums\CarStatusEnum;
use App\Http\Controllers\Controller;

use App\Models\Car;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use function App\Helpers\paginationResponseHelper;
use function App\Helpers\resolvePerPage;
use function App\Helpers\sendResponseHelper;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $service)
    {
    }
    public function addFavorite(Request $request)
    {
        $request->validate(['car_id' => ['required', 'integer']]);
        $response = $this->service->handleAddFavorite($request->car_id, $request->user());
        return sendResponseHelper(
            $response['status'] ? 201 : 400,
            $response['message']
        );
    }
    public function removeFavorite(Request $request)
    {
        $request->validate(['car_id' => ['required', 'integer']]);
        $response = $this->service->handleRemoveFavorite($request->car_id, $request->user());
        return $response ?
        sendResponseHelper(msg:'delete successfully'):
        sendResponseHelper(400,msg:'can not delete the item');
    }

    public function getFavorites(){
        $favoritesCars = $this->service->handleGetFavorites(request()->user());
        return paginationResponseHelper(data:$favoritesCars);
    }
}
