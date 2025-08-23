<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class VisitDateTimeAllowed implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $timezone = setting('timezone', 'UTC');
        $workingDays = setting('booking_working_days', []);
        if (!is_array($workingDays)) {
            $workingDays = explode(',', $workingDays);
        }
        $workingDays = array_map('strtolower', array_map('trim', $workingDays));
        try {
            $visitDate = Carbon::createFromFormat('d/m/Y', $value, $timezone);
        } catch (\Exception $e) {
            $fail(__('The :attribute format is invalid.'));
            return;
        }
        $visitDate->setTimezone($timezone);
        if ($visitDate->isBefore(Carbon::now($timezone)->startOfDay())) {
            $fail(__('The visit date must be in the future.'));
            return;
        }
        $dayName = strtolower($visitDate->format('l'));
        if (!in_array($dayName, $workingDays)) {
            $fail(__('Visits are only allowed on: :days.', [
                'days' => implode(', ', $workingDays),
            ]));
            return;
        }
    }
}
