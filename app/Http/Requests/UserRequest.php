<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        switch ($this->method())
        {
            case 'POST':
                return [
                    'email' => 'required|email|unique:users,email',
                    'name' => 'required|max:100',
                    'phone' => 'required|max:100',
                    'role_id' => 'required|integer|not_in:0',
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
            case 'PUT':
            case 'PATCH':
                $model = $this->route('user');
                $id = $model->id;
                return [
                    'email' => 'required|email|unique:users,email,' . $id . ',id',
                    'name' => 'required|max:100',
                    'phone' => 'required|max:100',
                    'role_id' => 'required|integer|not_in:0',
                ];
        }
    }

    public function messages()
    {
        return [
            'email.required' => 'Заполните E-mail',
            'email.email' => 'Некорректный E-mail',
            'email.unique' => 'E-mail уже занят',
            'name.required' => 'Заполните имя пользователя',
            'phone.required' => 'Заполните телефон',
            'role_id.required' => 'Выберите роль пользователя',
            'role_id.not_in' => 'Выберите роль пользователя',
            'new-password.required' => 'Заполните пароль',
            'new-password.regex' => 'Пароль должен содержать только символы латинского алфавита и цифры.',
            'new-password.min' => 'Длина пароля должна быть не менее 8 символов.',
            'new-password-confirm.required' => 'Повторите пароль',
            'new-password-confirm.same' => 'Пароли не совпадают',
        ];
    }
}
