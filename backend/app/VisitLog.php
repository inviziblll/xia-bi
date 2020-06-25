<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = true;

    protected $fillable = [
        'shop_id','date','count'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'shop_id' => 'integer',
        'count' => 'integer'
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

}
