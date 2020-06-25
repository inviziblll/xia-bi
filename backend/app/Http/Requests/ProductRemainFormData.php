<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRemainFormData extends FormRequest
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

            'product_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
            'operation_id' => 'required|integer',
            'count' => 'required|integer',
            'date' => 'required|date'

        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'product_id.required' => 'Поле "идентификатор продукта" пустое или информация в нем не корректна',
            'warehouse_id.required' => 'Поле "идентификатор склада" пустое или информация в нем не корректна',
            'operation_id.required' => 'Поле "идентификатор операции" пустое или информация в нем не корректна',
            'count.required' => 'Поле "количество" пустое или информация в нем не корректна',
            'date.required' => 'Поле "дата" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
