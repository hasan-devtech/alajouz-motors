<?php

namespace App\Http\Requests;

use App\Enums\CarEngineTypeEnum;
use App\Rules\BrandModelBelongsToBrand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSellingCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selling_request_id' => ['required', 'integer', Rule::exists('selling_requests', 'id')],
            'brand_id' => 'sometimes|required|exists:brands,id',
            'brand_model_id' => ['sometimes', 'required', Rule::exists("brand_models", 'id'), new BrandModelBelongsToBrand($this->input('brand_id') ?? 0)],
            'color_id' => 'sometimes|required|exists:colors,id',
            'car_type_id' => 'sometimes|required|exists:car_types,id',
            'year' => 'sometimes|required|integer|min:2000|max:' . now()->year,
            'distance' => 'sometimes|required|numeric|min:0',
            'engine' => 'sometimes|required|integer|min:0',
            'engine_type' => ['sometimes', 'required', Rule::in(enumValues(CarEngineTypeEnum::class))],
            'price' => 'sometimes|required|numeric|min:200',
            'vin' => 'sometimes|required|string|max:255',
            'new_car_images' => 'sometimes|array|min:1',
            'new_car_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_image_ids' => 'sometimes|array',
            'delete_image_ids.*' => ['integer', Rule::exists("images", "id")],
        ];
    }
}
