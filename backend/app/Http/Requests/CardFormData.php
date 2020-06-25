<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardFormData extends FormRequest
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
            'number'=>'required|numeric',
            'client_id'=>'nullable|numeric',
            'date_from'=>'date|nullable',
            'date_to'=>'date|nullable',
            'deleted_at'=>'date|nullable',
            'row_id'=>'numeric|nullable',

        ];
    }


    public function messages()
    {
        return [
            'number.required' => 'Объязательно указать номер',
        ];
    }
}
