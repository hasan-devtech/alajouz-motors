<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserCheckInRequest;
use App\Http\Resources\UserResource;
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

    public function getUserWorkHoursAndSalary(Request $request)
    {
        $user_id = $request->user()->id;
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2024|max:' . date('Y'),
        ]);
        $month = $validated['month'] ?? null;
        $year = $validated['year'] ?? null;
        $salaryData = $this->service->calculateUserSalary($user_id, $month, $year);
        return sendResponseHelper(data: $salaryData);
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();
        return sendResponseHelper(data: UserResource::make($user));
    }
}
