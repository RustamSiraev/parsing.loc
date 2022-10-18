<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'new-password' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9]+$/i',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],
            'new-password-confirm' => 'required|string|same:new-password',

        ];
    }

    public function messages(): array
    {
        return [
            'new-password.required' => 'Заполните пароль',
            'new-password.min' => 'Количество символов в поле пароль должно быть не меньше 8.',
            'new-password-confirm.required' => 'Повторите пароль',
            'new-password-confirm.same' => 'Пароли не совпадают',
            'new-password.regex' => 'Пароль должен содержать только символы латинского алфавита и цифры.',
        ];
    }
}
