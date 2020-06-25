<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitLogCopy extends Model
{
    use DateTimeMutatorsTrait;
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'visit_logs_copies';

    protected $fillable = [
        'shop_id','date','count', 'date_from', 'date_to'

    ];

//    protected $hidden = [
//        'created_at', 'updated_at', 'deleted_at'
//    ];

    protected $casts = [
        'shop_id' => 'integer',
        'count' => 'integer'
    ];
}
