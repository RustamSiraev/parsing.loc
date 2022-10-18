<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantRequest extends FormRequest
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
                    'l_name' => 'required|max:100',
                    'm_name' => 'max:100',
                    'f_name' => 'required|max:100',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|max:100',
                    'born_at' => 'required|max:100',
                    'snils' => 'required|max:100',
                    'gender' => 'required|integer',
                    'agree' => 'required|not_in:0',
                    'new-password' => 'required|string|min:8',
                    'new-password-confirm' => 'required|string|same:new-password',
                ];
            case 'PUT':
            case 'PATCH':
                $model = $this->route('applicant');
                $id = $model->getUser()->id;
                return [
                    'l_name' => 'required|max:100',
                    'm_name' => 'max:100',
                    'f_name' => 'required|max:100',
                    'email' => 'required|email|unique:users,email,' . $id . ',id',
                    'phone' => 'required|max:100',
                    'gender' => 'required|integer',
                    'born_at' => 'required|max:100',
                    'snils' => 'required|max:100',
                ];
        }
    }

    public function messages()
    {
        return [
            'l_name.required' => 'Заполните фамилию',
            'f_name.required' => 'Заполните имя',
            'agree.required' => 'Нужно согласие на обработку персональных данных',
            'email.required' => 'Заполните E-mail',
            'email.email' => 'Некорректный E-mail',
            'email.unique' => 'E-mail уже занят',
            'phone.required' => 'Заполните телефон',
            'new-password.required' => 'Заполните пароль',
            'new-password.min' => 'Количество символов в поле пароль должно быть не меньше 8',
            'new-password-confirm.required' => 'Повторите пароль',
            'new-password-confirm.same' => 'Пароли не совпадают',
            'born_at.required' => 'Заполните дату рождения',
            'snils.required' => 'Заполните СНИЛС',
        ];
    }
}
