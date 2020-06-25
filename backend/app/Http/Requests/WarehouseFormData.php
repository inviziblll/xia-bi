<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseFormData extends FormRequest
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
            'warehouse_type_id' => 'required|integer',
            'shop_id' => 'required|integer',
            'name' => 'required|string|min:0|max:255',
            'description' => 'string|min:0|max:255'
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'warehouse_type_id.required' => 'Поле "идентификатор типа склада" пустое или информация в нем не корректна',
            'shop_id.required' => 'Поле "идентификатор магазина" пустое или информация в нем не корректна',
            'name.required' => 'Поле "имя" пустое или информация в нем не корректна',
            'description.required' => 'Поле "описание" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
