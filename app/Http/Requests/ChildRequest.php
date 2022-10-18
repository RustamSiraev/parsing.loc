<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildRequest extends FormRequest
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
                    'category' => 'integer',
                    'citizenship' => 'required|integer',
                    'gender' => 'required|integer',
                    'born_place' => 'max:255',
                    'born_at' => 'required|max:100',
                    'birth_certificate_seria_a' => 'required_if:citizenship,1',
                    'birth_certificate_seria_b' => 'required_if:citizenship,1',
                    'birth_certificate_number' => 'required_if:citizenship,1,3',
                    'birth_certificate_created_at' => 'required_if:citizenship,1,3',
                    'doc_type' => 'integer',
                    'doc_seria' => 'max:100',
                    'doc_number' => 'max:100',
                    'doc_date' => 'max:100',
                    'house_id' => 'required|max:255',
                    'street_id' => 'required|max:255',
                    'house_num' => 'max:50',
                    'birth_certificate_scan' => 'mimes:pdf,png,jpg,gif|max:10000',
                    'parent_passport_scan' => 'mimes:pdf,png,jpg,gif|max:10000',
                    'registration_doc_scan' => 'mimes:pdf,png,jpg,gif|max:10000',
                    'birth_certificate' => 'string|max:255',
                    'parent_passport' => 'string|max:255',
                    'registration_doc' => 'string|max:255',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'l_name' => 'required|max:100',
                    'm_name' => 'max:100',
                    'f_name' => 'required|max:100',
                    'category' => 'integer',
                    'citizenship' => 'required|integer',
                    'gender' => 'required|integer',
                    'born_place' => 'max:255',
                    'born_at' => 'required|max:100',
                    'birth_certificate_seria_a' => 'required_if:citizenship,1',
                    'birth_certificate_seria_b' => 'required_if:citizenship,1',
                    'birth_certificate_number' => 'required_if:citizenship,1,3',
                    'birth_certificate_created_at' => 'required_if:citizenship,1,3',
                    'doc_type' => 'integer',
                    'doc_seria' => 'max:100',
                    'doc_number' => 'max:100',
                    'doc_date' => 'max:100',
                    'house_id' => 'required|max:255',
                    'street_id' => 'required|max:255',
                    'house_num' => 'max:50',
                    'birth_certificate' => 'string|max:255',
                    'parent_passport' => 'string|max:255',
                    'registration_doc' => 'string|max:255',
                ];
        }
    }

    public function messages()
    {
        return [
            'l_name.required' => 'Заполните фамилию',
            'f_name.required' => 'Заполните имя',
            'category.required' => 'Выберите тип представительства',
            'doc_seria.required_if' => 'Заполните серию документа',
            'doc_number.required_if' => 'Заполните номер документа',
            'doc_date.required_if' => 'Заполните дату выдачи',
            'born_at.required' => 'Заполните дату рождения',
            'agree.required' => 'Нужно согласие на обработку персональных данных',
            'email.required' => 'Заполните E-mail',
            'email.email' => 'Некорректный E-mail',
            'email.unique' => 'E-mail уже занят',
            'phone.required' => 'Заполните телефон',
            'password.required' => 'Заполните пароль',
            'password.min' => 'Количество символов в поле пароль должно быть не меньше 8.',
            'password-confirm.required' => 'Повторите пароль',
            'password-confirm.same' => 'Пароли не совпадают',
            'street_id.required' => 'Заполните адрес',
            'house_id.required' => 'Заполните дом',
            'house_num.required' => 'Заполните дом',
            'birth_certificate_seria_a.required_if' => 'Заполните серию свидетельства',
            'birth_certificate_seria_b.required_if' => 'Заполните серию свидетельства',
            'birth_certificate_number.required_if' => 'Заполните номер свидетельства',
            'birth_certificate_created_at.required_if' => 'Заполните дату выдачи свидетельства',
            'birth_certificate_scan.required' => 'Загрузите скан свидетельства о рождении',
            'parent_passport_scan.required' => 'Загрузите скан паспорта родителя',
        ];
    }
}
