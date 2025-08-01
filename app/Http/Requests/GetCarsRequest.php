<?php

namespace App\Http\Requests;

use App\Enums\CarEngineTypeEnum;
use App\Enums\CarTypeEnum;
use App\Rules\BrandModelBelongsToBrand;
use App\Rules\MaxPriceGreaterThanMinPrice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => 'nullable|exists:brands,id',
            'brand_model_id' => ['nullable', 'exists:brand_models,id', new BrandModelBelongsToBrand($this->input('brand_id'))],
            'color_id' => 'nullable|exists:colors,id',
            'year' => 'nullable|integer|min:2010|max:' . now()->year,
            'min_price' => 'nullable|numeric|min:1000',
            'max_price' => ['nullable', "numeric", "min:0", new MaxPriceGreaterThanMinPrice($this->input('min_price'))],
            'engine' => 'nullable|integer|min:0',
            'engine_type' => ['nullable', Rule::in(enumValues(CarEngineTypeEnum::class))],
            'car_type' => ['nullable', Rule::in(enumValues(CarTypeEnum::class))],
            'per_page' => 'nullable|integer',
        ];
    }
}
