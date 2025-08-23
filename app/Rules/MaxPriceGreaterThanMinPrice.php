<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxPriceGreaterThanMinPrice implements ValidationRule
{
    public function __construct(private $minPrice)
    {
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value) || is_null($this->minPrice)) {
            return;
        }
        if ($value < $this->minPrice) {
            $fail('max price should be greater than min price');
        }
    }
}
