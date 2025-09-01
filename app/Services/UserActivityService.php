<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use function App\Helpers\haversine;

class UserActivityService
{
    public function checkIn($ip, $device_id, $latitude, $longitude, $user_id)
    {
        $now = now()->setTimezone(setting('timezone'));
        $lastActivity = UserActivity::where('user_id', $user_id)
            ->whereNull('checked_out')
            ->latest('checked_in')
            ->first();
        if ($lastActivity) {
            if (Carbon::parse($lastActivity->checked_in)->isSameDay($now)) {
                return [
                    'status' => false,
                    'message' => 'You must check out before starting a new session'
                ];
            }
        }
        $maxDistance = (float) setting('checkin_max_distance');
        $distance = haversine($latitude, $longitude, setting('company_latitude'), setting('company_longitude'));
        if ($distance > $maxDistance) {
            return [
                'status' => false,
                'message' => "You are too far from the allowed check-in area"
            ];
        }
        $activity = UserActivity::create([
            'user_id' => $user_id,
            'device_id' => $device_id,
            'ip' => $ip,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'checked_in' => $now
        ]);
        return [
            'status' => true,
            'message' => 'checked in successfully',
            'checked_in_at' => $activity->checked_in->toDateTimeString()
        ];
    }

    public function checkOut($user_id)
    {
        $now = now()->setTimezone(setting('timezone'));
        $activity = UserActivity::where('user_id', $user_id)
            ->whereNull('checked_out')
            ->latest('checked_in')
            ->first();
        if (!$activity) {
            return [
                'status' => false,
                'message' => 'You are not currently checked in'
            ];
        }
        $activity->update(['checked_out' => $now]);
        return [
            'status' => true,
            'message' => 'checked out successfully',
            'checked_out_at' => $now->toDateTimeString()
        ];
    }

    public function calculateUserSalary($user_id, $month = null, $year = null)
    {
        $user = User::findOrFail($user_id);
        $monthlyExpectedHours = setting('monthly_expected_hours');
        $hourlyRate = $user->salary / $monthlyExpectedHours;
        $month = $month ?? Carbon::now()->month; 
        $year = $year ?? Carbon::now()->year;   
        $startDate = Carbon::create($year, $month, 1)->startOfDay();
        $current = Carbon::now();
        if ($year == $current->year && $month == $current->month) {
            $endDate = $current->copy()->endOfDay();
        } else {
            $endDate = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        }
        $activities = UserActivity::where('user_id', $user_id)
            ->whereBetween('checked_in', [$startDate, $endDate])
            ->orderBy('checked_in')
            ->get();
        $period = CarbonPeriod::create($startDate, $endDate);
        $daysData = [];
        $totalHours = 0;
        $totalSalary = 0;
        foreach ($period as $date) {
            $dayActivities = $activities->filter(function ($activity) use ($date) {
                return Carbon::parse($activity->checked_in)->isSameDay($date);
            });
            $sessions = [];
            $dayHours = 0;
            foreach ($dayActivities as $activity) {
                if ($activity->checked_in && $activity->checked_out) {
                    $hours = Carbon::parse($activity->checked_in)
                        ->diffInMinutes(Carbon::parse($activity->checked_out)) / 60;
                    $dayHours += $hours;
                    $sessions[] = [
                        'checked_in' => Carbon::parse($activity->checked_in)->format('H:i'),
                        'checked_out' => Carbon::parse($activity->checked_out)->format('H:i'),
                        'hours' => round($hours, 2)
                    ];
                }
            }
            $dailySalary = round($dayHours * $hourlyRate, 2);
            $daysData[] = [
                'date' => $date->toDateString(),
                'hours' => round($dayHours, 2),
                'daily_salary' => $dailySalary,
                'sessions' => $sessions
            ];
            $totalHours += $dayHours;
            $totalSalary += $dailySalary;
        }
        return [
            'total_hours' => round($totalHours, 2),
            'total_salary' => round($totalSalary, 2),
            'monthly_expected_hours' => $monthlyExpectedHours,
            'days' => $daysData
        ];
    }



}
