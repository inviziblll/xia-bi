<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitLogFormData extends FormRequest
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
            // 'shop_id' => 'required|integer',
            'date' => 'required|date',
            'count' => 'required|integer'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            // 'shop_id.required' => 'Поле "идентификатор магадина" пустое или информация в нем не корректна',
            'date.required' => 'Поле "дата" пустое или информация в нем не корректна',
            'count.required' => 'Поле "количество" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }


}
