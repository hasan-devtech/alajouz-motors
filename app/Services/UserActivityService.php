<?php

namespace App\Services;

use App\Models\UserActivity;
use function App\Helpers\haversine;

class UserActivityService
{
    public function checkIn($ip, $device_id, $latitude, $longitude, $user_id)
    {
        $now = now()->setTimezone(setting('timezone'));
        $isChecked = UserActivity::where('user_id', $user_id)
            ->whereDate('checked_in', $now->toDateString())
            ->exists();
        if ($isChecked) {
            return [
                'status' => false,
                'message' => 'User already checked_in  the system'
            ];
        }
        $maxDistance = (float) setting('checkin_max_distance');
        $distance = haversine($latitude, $longitude, setting('company_latitude'), setting('company_longitude'));
        if ($distance > $maxDistance) {
            return [
                'status' => false,
                'message' => "You are too far from the allowed check-in area"
            ];
        }
        UserActivity::create([
            'user_id' => $user_id,
            'device_id' => $device_id,
            'ip' => $ip,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'checked_in' => $now
        ]);
        return [
            'status' => true,
            'message' => 'checked_in successfully',
            'checked_in_at' => $now->toDateTimeString()
        ];
    }

    public function checkOut($user_id)
    {
        $now = now()->setTimezone(setting('timezone'));
        $today = $now->toDateString();
        $activity = UserActivity::where('user_id', $user_id)
            ->whereDate('checked_in', $today)
            ->first();
        if (!$activity) {
            return [
                'status' => false,
                'message' => 'u are not checked_in'
            ];
        }
        if ($activity->checked_out !== null) {
            return [
                'status' => false,
                'message' => 'u have already checked out'
            ];
        }
        $activity->update(['checked_out' => $now]);
        return [
            'status' => true,
            'message' => 'checked_out successfully',
            'checked_out_at' => $now->toDateTimeString()
        ];
    }
}
