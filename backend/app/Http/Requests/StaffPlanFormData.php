<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffPlanFormData extends FormRequest
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
            'shop_id' => 'required|integer',
            'role_id' => 'required|integer',
            'date_from' => 'required|string|min:0|max:255',
            'date_to' => 'string|min:0|max:255'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'shop_id.required' => 'Поле "идентификатор магазина" пустое или информация в нем не корректна',
            'role_id.required' => 'Поле "идентификатор роли" пустое или информация в нем не корректна',
            'date_from.required' => 'Поле "дата из" пустое или информация в нем не корректна',
            'date_to.required' => 'Поле "дата в" пустое или информация в нем не корректна'
        ];
    }


    public function getData()
    {
        return $this->all();
    }

}
