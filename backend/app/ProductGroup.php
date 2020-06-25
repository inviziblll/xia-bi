<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use DateTimeMutatorsTrait;

    /**
     * обязательные поля при создании записи
     */
    protected $fillable = [
        'name', 'description', 'pivot'
    ];


    /**
     * скрытые поля
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at','pivot'
    ];

    /**
     *  методы для работы со связанными моделями
     */

    public function products()
    {
        return $this->belongsTo('App\Product','product_id');
    }

}
