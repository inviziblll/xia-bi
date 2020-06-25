<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopFormData extends FormRequest
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
                'company_id' => 'required|integer',
                'city_id' => 'required|integer',
                'shop_type_id' => 'required|integer',
                'division_id' => 'required|integer',
                //'warehouse_from_id' => 'required|integer',
                //'warehouse_to_id' => 'required|integer',
                //'encashment' => 'required|float',
                'name' => 'required|string',
                'description' => 'string'
            ];

        return $rules;

    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "имя" пустое или информация в нем не корректна',
            'description.required' => 'Поле "описание" пустое или информация в нем не корректна',
            'company_id.required' => 'Поле "идентификатор компании" пустое или информация в нем не корректна',
            'city_id.required' => 'Поле "идентификатор города" пустое или информация в нем не корректна',
            'shop_type_id.required' => 'Поле "идентификатор типа магазина" пустое или информация в нем не корректна'
//            'encashment.required' => 'Поле "инкассация" пустое или информация в нем не корректна',
//            'warehouse_from_id.required' => 'Поле "идентификатор склада из магазина" пустое или информация в нем не корректна',
//            'warehouse_to_id.required' => 'Поле "идентификатор склада в магазин" пустое или информация в нем не корректна'

        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
