<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
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
                    'l_name' => 'required|max:20|regex:/^[а-яА-ЯЁё]/u',
                    'm_name' => 'max:100',
                    'f_name' => 'required|max:15|regex:/^[а-яА-ЯЁё]/u',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|max:100',
                    'additional_contact' => 'max:16',
                    'citizenship' => 'required|integer|not_in:0',
                    'gender' => 'required|integer',
                    'doc_type' => 'required|not_in:0',
                    'doc_seria' => 'max:100',
                    'doc_number' => 'required|max:100',
                    'doc_date' => 'required|max:100',
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
                    'house_id' => 'max:255',
                    'street_id' => 'required|max:255',
                    'house_num' => 'max:50',
                    'flat' => 'max:50',
                    'fact_house_id' => 'max:255',
                    'fact_street_id' => 'required_if:matches,==,0|max:255',
                    'fact_house_num' => 'max:255',
                ];
            case 'PUT':
            case 'PATCH':
                $model = $this->route('applicant');
                $id = $model->getUser()->id;
                return [
                    'l_name' => 'required|max:20|regex:/^[а-яА-ЯЁё]/u',
                    'm_name' => 'max:100',
                    'f_name' => 'required|max:15|regex:/^[а-яА-ЯЁё]/u',
                    'email' => 'required|email|unique:users,email,' . $id . ',id',
                    'phone' => 'required|max:100',
                    'additional_contact' => 'max:16',
                    'citizenship' => 'required|integer|not_in:0',
                    'gender' => 'required|integer',
                    'doc_type' => 'required|not_in:0',
                    'doc_seria' => 'max:100',
                    'doc_number' => 'required|max:100',
                    'doc_date' => 'required|max:100',
                    'house_id' => 'max:255',
                    'street_id' => 'required|max:255',
                    'house_num' => 'max:50',
                    'flat' => 'max:50',
                    'fact_house_id' => 'max:255',
                    'fact_street_id' => 'required_if:matches,==,0|max:255',
                    'fact_house_num' => 'max:255',
                ];
        }
    }

    public function messages()
    {
        return [
            'l_name.required' => 'Заполните фамилию',
            'f_name.required' => 'Заполните имя',
            'l_name.regex' => 'Допускаются только буквы русского алфавита',
            'f_name.regex' => 'Допускаются только буквы русского алфавита',
            'doc_seria.required_if' => 'Заполните серию документа',
            'doc_number.required_if' => 'Заполните номер документа',
            'doc_date.required_if' => 'Заполните дату выдачи',
            'agree.required' => 'Нужно согласие на обработку персональных данных',
            'email.required' => 'Заполните E-mail',
            'email.email' => 'Некорректный E-mail',
            'email.unique' => 'E-mail уже занят',
            'phone.required' => 'Заполните телефон',
            'password.required' => 'Заполните пароль',
            'password-confirm.required' => 'Повторите пароль',
            'password-confirm.same' => 'Пароли не совпадают',
            'street_id.required' => 'Заполните адрес',
            'house_id.required' => 'Заполните дом',
            'house_num.required' => 'Заполните дом',
            'fact_house_id.required_if' => 'Заполните адрес',
            'fact_street_id.required_if' => 'Заполните дом',
            'fact_house_num.required_if' => 'Заполните дом',
            'password.regex' => 'Пароль должен содержать только символы латинского алфавита и цифры.',
            'password.min' => 'Длина пароля должна быть не менее 8 символов.',
        ];
    }
}
