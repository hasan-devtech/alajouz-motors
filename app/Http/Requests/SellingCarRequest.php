<?php

namespace App\Http\Requests;

use App\Enums\CarEngineTypeEnum;
use App\Enums\CarTypeEnum;
use App\Rules\BrandModelBelongsToBrand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Input\Input;

class SellingCarRequest extends FormRequest
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
            'brand_id' => 'required|exists:brands,id',
            'brand_model_id' => ['required', 'exists:brand_models,id', new BrandModelBelongsToBrand($this->input('brand_id'))],
            'color_id' => 'required|exists:colors,id',
            'year' => 'required|integer|min:1990|max:' . now()->year,
            'distance' => ['required', 'numeric', 'min:0'],
            'engine' => 'required|integer|min:0',
            'engine_type' => ['required', Rule::in(enumValues(CarEngineTypeEnum::class))],
            'car_type' => ['required', Rule::in(enumValues(CarTypeEnum::class))],
            'price' => 'required|numeric|min:200',
            'vin' => 'required|string|max:255',
            'car_images' => 'required|array|min:1',
            'car_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}
