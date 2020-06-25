<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoeffFormData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'coeff_type_id' => 'required|integer',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            //'day' => 'required|integer',
            'value' => 'required|string|min:0|max:255'
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'coeff_type_id.required' => 'Поле "идентификатор типа коэффициента" пустое или информация в нем не корректна',
            'date_from.required' => 'Поле "дата из" пустое или информация в нем не корректна',
            'date_to.required' => 'Поле "дата в" пустое или информация в нем не корректна',
            //'day.required' => 'Поле "день" пустое или информация в нем не корректна',
            'value.required' => 'Поле "значение" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
