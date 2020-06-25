<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductGroupPlanType extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = true;

    /**
     * обязательные поля при создании записи
     */
    protected $fillable = [
        'name', 'description'
    ];


    /**
     * скрытые поля
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
