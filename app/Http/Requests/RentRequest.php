<?php
namespace App\Http\Requests;


use App\Rules\MinRentalDays;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'car_id' => ['required', 'integer'],
            'start_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'end_date' => [
                'required',
                'date_format:Y-m-d',
                'after:start_date',
                new MinRentalDays(setting('min_rental_days')),
            ],
            'license' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
        if ($this->isMethod('PUT')) {
            foreach ($rules as $field => $rule) {
                if (is_array($rule)) {
                    $rules[$field] = array_merge(['sometimes'], $rule);
                } else {
                    $rules[$field] = 'sometimes|' . $rule;
                }
            }
        }
        return $rules;
    }

    protected function passedValidation()
    {
        if ($this->filled('start_date') && $this->filled('end_date')) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $this->merge(['rental_days' => $start->diffInDays($end) + 1]);
        }

    }
}