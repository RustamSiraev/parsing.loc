<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'street_id' => 'required|max:255|unique:streets,guid',
        ];
    }

    public function messages()
    {
        return [
            'street_id.required' => 'Выберите населенный пункт, улицу',
            'street_id.unique' => 'Адрес уже добавлен',
        ];
    }
}
