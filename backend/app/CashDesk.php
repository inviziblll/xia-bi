<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class CashDesk extends Model
{
    use DateTimeMutatorsTrait;
    public $timestamps = true;

    protected $fillable = [
        'shop_id', 'name', 'description'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

    protected $casts = [
        'shop_id'=>'integer'
    ];
    
}
