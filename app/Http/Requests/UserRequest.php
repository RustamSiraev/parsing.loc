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
        switch ($this->method()) {
            case 'POST':
                return [
                    'email' => 'required|email|unique:users,email',
                    'name' => 'required|max:100',
                    'phone' => 'required|max:100',
                    'role_id' => 'required|integer|not_in:0',
                    'gender' => 'required|integer|not_in:0',
                    'born_at' => 'required|max:100',
                    'snils' => 'required|digits:11',
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
                // получаем объект модели из маршрута: user/{user}
                $model = $this->route('user');
                // из объекта модели получаем уникальный идентификатор для валидации
                $id = $model->id;
                return [
                    /*
                     * Проверка на уникальность email, исключая этого пользователя по идентификатору:
                     * 1. users — таблица базы данных, где проверяется уникальность
                     * 2. email — имя колонки, уникальность значения которой проверяется
                     * 3. значение, по которому из проверки исключается запись таблицы БД
                     * 4. поле, по которому из проверки исключается запись таблицы БД
                     * Для проверки будет использован такой SQL-запрос к базе данных
                     * SELECT COUNT(*) FROM `users` WHERE `email` = '...' AND `id` <> 17
                     */
                    'email' => 'required|email|unique:users,email,' . $id . ',id',
                    'name' => 'required|max:100',
                    'phone' => 'required|max:100',
                    'role_id' => 'required|integer|not_in:0',
                    //'college_id' => 'required_if:role_id,==,2|required_if:role_id,==,3|not_in:0',
                    'gender' => 'required|integer|not_in:0',
                    'born_at' => 'required|max:100',
                    'snils' => 'required|digits:11',
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
            'college_id.required_if' => 'Выберите СПО',
            'college_id.not_in' => 'Выберите СПО',
            'gender.required' => 'Выберите пол',
            'gender.not_in' => 'Выберите пол',
            'born_at.required' => 'Заполните дату рождения',
            'snils.required' => 'Заполните СНИЛС',
            'digits.required' => 'Некорректный СНИЛС',
            'new-password.required' => 'Заполните пароль',
            'new-password.regex' => 'Пароль должен содержать только символы латинского алфавита и цифры.',
            'new-password.min' => 'Длина пароля должна быть не менее 8 символов.',
            'new-password-confirm.required' => 'Повторите пароль',
            'new-password-confirm.same' => 'Пароли не совпадают',
        ];
    }
}
