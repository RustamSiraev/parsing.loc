<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    public string $name;
    public string $email;
    public string $phone;
    public string $password;

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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|max:20|regex:/^[a-zA-Zа-яА-ЯЁё0-9]/u',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|max:100',
                    'agree' => 'required|not_in:0',
                    'password' => [
                        'required',
                        'string',
                        'regex:/^[a-zA-Z0-9]+$/i',
                        Password::min(8)
                            ->mixedCase()
                            ->numbers(),
                    ],
                    'password-confirm' => 'required|string|same:password',
                ];
            case 'PUT':
            case 'PATCH':
                $model = $this->route('user');
                $id = $model->getUser()->id;
                return [
                    'name' => 'required|max:20|regex:/^[a-zA-Zа-яА-ЯЁё0-9]/u',
                    'email' => 'required|email|unique:users,email,' . $id . ',id',
                    'phone' => 'required|max:100',
                ];
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Заполните имя',
            'name.regex' => 'Допускаются только буквы и цифры',
            'agree.required' => 'Нужно согласие на обработку персональных данных',
            'email.required' => 'Заполните E-mail',
            'email.email' => 'Некорректный E-mail',
            'email.unique' => 'E-mail уже занят',
            'phone.required' => 'Заполните телефон',
            'password.required' => 'Заполните пароль',
            'password-confirm.required' => 'Повторите пароль',
            'password-confirm.same' => 'Пароли не совпадают',
            'password.regex' => 'Пароль должен содержать только символы латинского алфавита и цифры.',
            'password.min' => 'Длина пароля должна быть не менее 8 символов.',
        ];
    }
}
