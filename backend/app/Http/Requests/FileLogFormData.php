<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileLogFormData extends FormRequest
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
            'status' => 'required|integer',
            'file_name' => 'required|string|min:0|max:255',
            'path' => 'required|string|min:0|max:255',
            'description' => 'string|min:0|max:255'
        ];
        return $rules;
    }


    public function messages()
    {
        return [
            'status.required' => 'Поле "статус" пустое или информация в нем не корректна',
            'description.required' => 'Поле "описание" пустое или информация в нем не корректна',
            'file_name.required' => 'Поле "Имя файла" пустое или информация в нем не корректна',
            'path.required' => 'Поле "Путь" пустое или информация в нем не корректна'
        ];
    }


    public function getData()
    {
        return $this->all();
    }
}
