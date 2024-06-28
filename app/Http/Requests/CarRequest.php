<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
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
            'model'=>'required|min:3|unique:cars,model',
            'price'=>'required|numeric|min:20',
            'park'=>'required|exists:parks,id',
            'drivers.*'=>'required|exists:drivers,id',
            'images.*'=>'nullable|image'
        ];
    }
}
