<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class VisitDateTimeAllowed implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $timezone = setting('timezone');
        $workingDays = setting('booking_working_days');
        $startTime = setting('booking_start_time');
        $endTime = setting('booking_end_time');
        try {
            $visitDate = Carbon::createFromFormat('d/m/Y H:i', $value, $timezone);
        } catch (\Exception $e) {
            $fail('The :attribute format is invalid.');
            return;
        }
        $visitDate->setTimezone($timezone);
        if ($visitDate->isPast()) {
            $fail('The visit date must be in the future.');
            return;
        }
        $dayName = strtolower($visitDate->format('l'));
        if (!in_array($dayName, $workingDays)) {
            $fail('Visits are only allowed on: ' . implode(', ', $workingDays) . '.');
            return;
        }
        $time = $visitDate->format('H:i');
        if ($time < $startTime || $time > $endTime) {
            $fail("Visits must be scheduled between {$startTime} and {$endTime}.");
            return;
        }
    }
}
