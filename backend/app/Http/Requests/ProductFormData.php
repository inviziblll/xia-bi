<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormData extends FormRequest
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
            // 'product_group_id' => 'required|integer',
            'product_type_id' => 'required|integer',
            'product_brand_id' => 'required|integer',
            'measure_type_id' => 'required|integer',
            'sku' => 'required|string|min:0|max:255',
            'full_name' => 'required|string|min:0|max:255',
            'name' => 'required|string|min:0|max:255',
            'description' => 'string|min:0|max:255'
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'Поле "имя" пустое или информация в нем не корректна',
            'description.required' => 'Поле "описание" пустое или информация в нем не корректна',
            // 'product_group_id.required' => 'Поле "идентификатор группы" пустое или информация в нем не корректна',
            'product_type_id.required' => 'Поле "идентификатор типа" пустое или информация в нем не корректна',
            'product_brand_id.required' => 'Поле "идентификатор бренда" пустое или информация в нем не корректна',
            'measure_type_id.required' => 'Поле "идентификатор размера" пустое или информация в нем не корректна',
            'sku.required' => 'Поле "торговое предложение" пустое или информация в нем не корректна',
            'full_name.required' => 'Поле "полное имя" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
