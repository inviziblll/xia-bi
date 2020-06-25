<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductGroupPlanFormData extends FormRequest
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
        return [
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'product_group_plan_type_id' => 'required|integer',
            'value' => 'string|min:0|max:255'

        ];
    }

    public function messages()
    {
        return [
            'date_from.required' => 'Поле "дата из" пустое или информация в нем не корректна',
            'date_to.required' => 'Поле "дата в" пустое или информация в нем не корректна',
            'product_group_plan_type_id.required' => 'Поле "идентификатор плана типа группы продукта" пустое или информация в нем не корректна',
            'value.required' => 'Поле "значение" пустое или информация в нем не корректна',
        ];
    }


    public function getData()
    {
        return $this->all();
    }

}
