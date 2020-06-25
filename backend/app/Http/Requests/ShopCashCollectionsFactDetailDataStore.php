<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopCashCollectionsFactDetailDataStore extends FormRequest
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
            'shop_cash_collection_id' => 'required|numeric',
            'date' => 'required|date',
            'fact_value' => 'nullable',
            'deleted_at' => 'required|date'
        ];
    }
}
