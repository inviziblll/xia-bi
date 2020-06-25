<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductGroupPlan extends Model
{


    use DateTimeMutatorsTrait;

    public $timestamps = true;

    /**
     * обязательные поля при создании записи
     */
    protected $fillable = [
        'product_group_plan_type_id', 'date_from', 'date_to', 'value', 'product_group_id'
    ];


    /**
     * скрытые поля
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    protected $casts = [
        'product_group_plan_type_id' => 'integer',
        'product_group_id' => 'integer',
        'value' => 'float'
    ];


}
