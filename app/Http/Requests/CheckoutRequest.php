<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
           'car_id'=>'required|exists:cars,id',
           'price'=>'required',
           'model'=>'required',
           'start'=>'required|date',
           'finish'=>'required|date|after:start',
           'driver'=>'required|exists:drivers,id',
        ];
    }

    public function messages()
    {
        return [
          ...parent::messages(),
          'finish'=>'Finish date must be after Start date',
          'start'=>'Start date is required',
          'driver'=>'Driver is required',
        ];
    }

}
