<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserCheckInRequest;
use App\Services\UserActivityService;
use Illuminate\Http\Request;
use function App\Helpers\sendResponseHelper;

class UserActivityController extends Controller
{
    public function __construct(private UserActivityService $service)
    {
    }
    public function checkIn(UserCheckInRequest $request)
    {
        $ip = request()->ip();
        $user_id = request()->user()->id;
        $data = $request->validated();
        $result = $this->service->checkIn($ip, $data['device_id'], $data['latitude'], $data['longitude'], $user_id);
        return sendResponseHelper($result['status'] ? 200 : 400, $result['message']);
    }
    public function checkOut()
    {
        $user_id = request()->user()->id;
        $result = $this->service->checkOut($user_id);
        return sendResponseHelper($result['status'] ? 200 : 400, $result['message']);
    }
}
