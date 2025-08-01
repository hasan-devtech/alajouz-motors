<?php

namespace App\Rules;

use App\Models\BrandModel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BrandModelBelongsToBrand implements ValidationRule
{
    protected mixed $brandId;

    public function __construct(mixed $brandId)
    {
        $this->brandId = $brandId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value) || is_null($this->brandId)) {
            return; 
        }
        $exists = BrandModel::where('id', $value)
            ->where('brand_id', $this->brandId)
            ->exists();
        if (! $exists) {
            $fail('the brand_model should belongs to the brand of car');
        }
    }
}
