<?php

namespace App; 

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductReceiptionDetail extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = true;

    protected $fillable = [
        'product_receiption_header_id', 'product_id','count','price','amount'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

    protected $casts = [
        'product_receiption_header_id'=>'integer',
        'product_id'=>'integer',
        'user_id'=>'integer',
        'count'=>'integer',
        'price'=>'float',
        'amount'=>'float'
    ];
}
