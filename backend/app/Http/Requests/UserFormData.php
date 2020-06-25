<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormData extends FormRequest
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
            'name' => 'required|string|min:0|max:255',
            'email' => 'required|email|min:0|max:255',
            'password' => 'required|string|min:6',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
             'name.required' => 'Поле "имя" пустое или информация в нем не корректна',
             'email.required' => 'Поле "email" пустое или информация в нем не корректна',
             'password.required' => 'Поле "password" пустое или информация в нем не корректна'
        ];
    }

    public function getData()
    {
        return $this->all();
    }
}
