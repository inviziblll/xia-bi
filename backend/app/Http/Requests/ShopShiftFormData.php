<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopShiftFormData extends FormRequest
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
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'date'=>'string|min:0|max:255'
        ];

        return $rules; 
    }


    public function messages()
    {
        return [
            'shop_id.required' => 'Поле "идентификатор магазина" пустое или информация в нем не корректна',
            'user_id.required' => 'Поле "идентификатор пользователя" пустое или информация в нем не корректна',
            'role_id.required' => 'Поле "идентификатор роли" пустое или информация в нем не корректна',
            'shift_id.required' => 'Поле "идентификатор смены" пустое или информация в нем не корректна',
            'date.required' => 'Поле "дата" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
