<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReceiptionHeaderFormData extends FormRequest
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
            'warehouse_id' => 'required|integer',
            'number' => 'required|string|min:0|max:255',
            'date'=>'required|date'
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'warehouse_id.required' => 'Поле "идентификатор склада" пустое или информация в нем не корректна',
            'number.required' => 'Поле "номер" пустое или информация в нем не корректна',
            'date.required' => 'Поле "дата" пустое или информация в нем не корректна',
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
