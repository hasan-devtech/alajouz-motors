<?php

namespace App\Http\Requests;

use App\Rules\VisitDateTimeAllowed;
use Illuminate\Foundation\Http\FormRequest;

class BookingCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected $minAmount = setting('min_amount'); 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'car_id' => 'required',
            'amount' => ['required','integer' ,'min:'. $minAmount],
            'visit_date' => ['required','date_format:Y-m-d',new VisitDateTimeAllowed()]
        ];
    }
}
