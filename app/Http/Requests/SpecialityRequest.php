<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialityRequest extends FormRequest
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
                    'code' => 'required|string|max:255|unique:specialities,code',
                    'name' => 'required|string|max:555|unique:specialities,name',
                    'education_level' => 'required|integer',
                    'education_form' => 'required|integer',
                    'budgetary' => 'required|integer',
                    'commercial' => 'required|integer',
                    'education_cost' => 'required|integer',
                    'education_time' => 'required|integer',
                ];
            case 'PUT':
            case 'PATCH':
                $model = $this->route('speciality');
                return [
                    'code' => 'required|string|max:255|unique:specialities,code,' . $model->id . ',id',
                    'name' => 'required|string|max:555|unique:specialities,name,' . $model->id . ',id',
                    'education_level' => 'required|integer',
                    'education_form' => 'required|integer',
                    'budgetary' => 'required|integer',
                    'commercial' => 'required|integer',
                    'education_cost' => 'required|integer',
                    'education_time' => 'required|integer',
                ];
        }
    }

    public function messages()
    {
        return [
            'code.required' => 'Заполните код специальности',
            'code.unique' => 'Код специальности уже есть в системе',
            'name.required' => 'Заполните наименование специальности',
            'budgetary.required' => 'Укажите количество бюджетных мест',
            'commercial.required' => 'Укажите количество внебюджетных мест',
            'education_cost.required' => 'Укажите срок обучения в месяцах',
            'education_time.required' => 'Укажите стоимость обучения за год',
        ];
    }
}
