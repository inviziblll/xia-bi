<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopCashCollectionsDataStore extends FormRequest
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
            'shop_id'=>'required|numeric',
            'date_from' =>'required|date',
            'date_to' =>'required|date',
            'plan_value' =>'nullable',
            'deleted_at' =>'nullable|date'
        ];
    }
}
