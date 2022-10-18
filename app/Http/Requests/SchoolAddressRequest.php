<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'street_id' => 'required|max:255',
            'house_id' => 'required|max:255|unique:houses,guid',
            'house_num' => 'max:50',
        ];
    }

    public function messages()
    {
        return [
            'street_id.required' => 'Выберите населенный пункт, улицу',
            'house_id.required' => 'Выберите дом',
            'house_id.unique' => 'Дом уже закреплен за школой',
        ];
    }
}
