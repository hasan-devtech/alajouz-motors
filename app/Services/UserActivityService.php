<?php

namespace App\Services;

use App\Models\UserActivity;
use function App\Helpers\haversine;

class UserActivityService
{
    public function checkIn($ip, $device_id, $latitude, $longitude, $user_id)
    {
        $isChecked = UserActivity::where('user_id', $user_id)
            ->whereDate('checked_in', now()->toDateString())->exists();
        if ($isChecked) {
            return [
                'status' => false,
                'message' => 'User already checked_in  the system'
            ];
        }
        $distance = haversine($latitude, $longitude, ALAJOUZ_LATITUDE, ALAJOUZ_LONGITUDE);
        if ($distance > 0.2) {
            return [
                'status' => false,
                'message' => "u are too far to check"
            ];
        }
        UserActivity::create([
            'user_id' => $user_id,
            'device_id' => $device_id,
            'ip' => $ip,
            'latitude' => $latitude,
            'longitude' => $longitude,
            //maybe will set the timezone if the server in another country
            'checked_in' => now()
        ]);
        return [
            'status' => true,
            'message' => 'checked_in successfully'
        ];
    }
}
