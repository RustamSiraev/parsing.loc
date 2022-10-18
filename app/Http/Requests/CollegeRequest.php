<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollegeRequest extends FormRequest
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
        if (auth()->user()->isAdmin()) {
            return [
                'full_title' => 'required|max:555',
                'title' => 'required|max:255',
                'director_id' => 'required|integer|not_in:0',
            ];
        } else {
            return [
                'full_title' => 'required|max:555',
                'title' => 'required|max:255',
                'director_id' => 'required|integer',
                'inn' => 'required|digits:10',
                'kpp' => 'required|digits:9',
                'ogrn' => 'required|digits:13',
                'bank_name' => 'required|max:555',
                'c_acc' => 'required|digits:20',
                'bank_bik' => 'required|digits:9',
                'okpo' => 'required|max:10',
                'jur_address' => 'required|max:555',
                'post_address' => 'required|max:555',
                'phone' => 'required|max:255',
                'email' => 'required|email',
                'ek_acc' => 'required|max:255',
                'k_acc' => 'required|max:255',
                'l_acc' => 'required|max:255',
                'bl_acc' => 'required|max:255',
            ];
        }
    }

    public function messages()
    {
        return [
            'full_title.required' => 'Введите полное наименование',
            'title.required' => 'Введите краткое наименование',
            'full_title.max' => 'Слишком длинное полное наименование',
            'title.max' => 'Слишком длинное краткое наименование',
            'director_id.required' => 'Выберите директора из списка',
            'director_id.not_in' => 'Выберите директора из списка',
        ];
    }
}
