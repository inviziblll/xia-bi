<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class CoeffType extends Model
{

    use DateTimeMutatorsTrait;

    public $table = 'coeff_types';

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



    /**
     *  методы для работы со связанными моделями
     */

//    public function coeff()
//    {
//        return $this->hasOne('App\Coeff');
//    }

}
