<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinRentalDays implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct(private $minDays)
    {
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $start = Carbon::parse(request('start_date'));
        $end = Carbon::parse($value);
        if ($start->diffInDays($end) < $this->minDays) {
            $fail("The rental period must be at least {$this->minDays} day(s).");
        }
    }
}
