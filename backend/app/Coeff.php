<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Coeff extends Model
{

    use DateTimeMutatorsTrait;

    public $table = 'coeffs';

    public $timestamps = true;
    /**
     * скрытые поля
     */


    /**
     * обязательные поля при создании записи
     * 2018-04-12 10:25:15.000
     */
    protected $fillable = [
        'coeff_type_id', 'date_from', 'date_to', 'day', 'value'
    ];


    protected $hidden = [
         'created_at', 'updated_at', 'deleted_at'
    ];


    /**
     * скрытые поля
     */

    protected $casts = [
        'coeff_type_id'=>'integer',
        'day'=>'integer',
        'value'=>'float'
    ];

    /**
     *  методы для работы со связанными моделями
     */

//    public function coefftypes()
//    {
//        return $this->belongsTo('App\CoeffType');
//    }

}
