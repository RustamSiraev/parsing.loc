<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'number' => 'required|integer',
            'letter' => 'required|string',
            'study_year_id' => 'required|integer',
            'capacity' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'Выберите класс',
            'letter.required' => 'Выберите литеру',
            'study_year_id.required' => 'Выберите учебный год',
            'capacity.required' => 'Выберите наполняемость',
        ];
    }
}
