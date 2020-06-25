<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckDetailFormData extends FormRequest
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
            'check_header_id' => 'required|integer',
            'product_id' => 'required|integer',
            //'user_id' => 'required|integer',
            'count' => 'required|integer',
            'price' => 'required|string|min:0|max:255',
            'amount' => 'required|string|min:0|max:255',
            'check_type_id'=>'nullable',
            'discount' =>'nullable',
            'discount_percent' => 'nullable',
            'bonus' => 'nullable'
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'check_header_id.required' => 'Поле "идентификатор check_header" пустое или информация в нем не корректна',
            'product_id.required' => 'Поле "идентификатор продукта" пустое или информация в нем не корректна',
            // 'user_id.required' => 'Поле "идентификатор пользователя" пустое или информация в нем не корректна',
            'count.required' => 'Поле "количестово товаров" пустое или информация в нем не корректна',
            'price.required' => 'Поле "цена" пустое или информация в нем не корректна',
            'amount.required' => 'Поле "сумма товаров" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
