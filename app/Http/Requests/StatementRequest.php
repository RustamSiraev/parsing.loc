<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatementRequest extends FormRequest
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
            'college_id' => 'required|integer|not_in:0',
            'education_form' => 'required|integer|not_in:0',
            'speciality_id' => 'required|integer|not_in:0',
            'agree' => 'required|not_in:0',
            'deadlines' => 'required|not_in:0',
            'documents' => 'required|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'college_id.required' => 'Выберите образовательную организацию',
            'education_form.required' => 'Выберите форму обучения',
            'speciality_id.required' => 'Выберите специальность',
            'agree.required' => 'Нужно согласие на обработку персональных данных',
            'documents.required' => 'Нужно подтверждение ознакомления',
            'deadlines.required' => 'Нужно подтверждение ознакомления',
        ];
    }
}
