<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductRemain extends Model
{

    use DateTimeMutatorsTrait;

    public $table = 'product_remains';

    public $timestamps = true;

    protected $fillable = [
        'product_id', 'warehouse_id', 'operation_id', 'date', 'count'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

    protected $casts = [
        'product_id'=>'integer',
        'warehouse_id'=>'integer',
        'operation_id'=>'integer',
        'count'=>'integer'
    ];


    /**
     *  методы для работы со связанными моделями
     */

    public function product()
    {
        return $this->belongsTo('App\Product');

    }

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');

    }

    public function operation()
    {
        return $this->belongsTo('App\Operation');

    }
}
