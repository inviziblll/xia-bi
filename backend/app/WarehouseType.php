<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class WarehouseType extends Model
{

    use DateTimeMutatorsTrait;
    public $timestamps = true;

    protected $fillable = [
        'name', 'description'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

//    protected $casts = [
//        'warehouse_type_id'=>'integer',
//        'shop_id'=>'integer'
//    ];
}
