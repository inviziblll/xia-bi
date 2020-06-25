<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientFormData extends FormRequest
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
            'name'=>'required|string',
            'last_name'=>'required|string',
            'middle_name'=>'required|string',
            'birth'=>'required|date',
            'email'=>'email|nullable',
            'phone'=>'string|nullable',
            'description'=>'string|nullable',
            'deleted_at'=>'date|nullable',
            'row_id'=>'numeric|nullable',

        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Объязательно указать фамиля',
            'last_name.required'  => 'Объязательно указать имя',
            'middle_name.required'  => 'Объязательно указать отчество',
            'birth.required'  => 'Объязательно указать дату рождения',
        ];
    }
}
