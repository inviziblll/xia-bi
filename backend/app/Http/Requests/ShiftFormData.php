<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftFormData extends FormRequest
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
            'name' => 'required|string|min:0|max:255',
            'hour_from' => 'required|integer',
            'hour_to' => 'required|integer',
            'description' => 'string|min:0|max:255'
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'Поле "имя" пустое или информация в нем не корректна',
            'hour_from.required' => 'Поле "час от" пустое или информация в нем не корректна',
            'hour_to.required' => 'Поле "час в" пустое или информация в нем не корректна',
            'description.required' => 'Поле "описание" пустое или информация в нем не корректна'
        ];

    }

    public function getData()
    {
        return $this->all();
    }

}
