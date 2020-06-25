<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckHeaderFormData extends FormRequest
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

    public function rules()
    {
        $rules = [
            // 'check_type_id' => 'required|integer',
            // 'check_operation_id' => 'required|integer',
            'cash_desk_id' => 'required|integer',
            'date' => 'required|date',
            'change_number' => 'required|string|min:0|max:255',
            'check_number' =>'required|string|min:0|max:255',
            // 'check_status'=> 'required|string|min:0|max:255'
        ];

        return $rules;
    }

        public function messages()
    {
        return [
            'check_type_id.required' => 'Поле "идентификатор типа проверки" пустое или информация в нем не корректна',
            'check_operation_id.required' => 'Поле "идентификатор  операции" пустое или информация в нем не корректна',
            'cash_desk_id.required' => 'Поле "идентификатор кассы" пустое или информация в нем не корректна',
            'date.required' => 'Поле "дата" пустое или информация в нем не корректна',
            'change_number.required' => 'Поле "изменение номера" пустое или информация в нем не корректна',
            'check_number.required' => 'Поле "проверка номерае" пустое или информация в нем не корректна',
            'check_status.required' => 'Поле "проверка статуса" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
