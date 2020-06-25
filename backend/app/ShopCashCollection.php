<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ShopCashCollection extends Model
{

    use DateTimeMutatorsTrait;

    protected $fillable = ['shop_id','date_from','date_to','plan_value','deleted_at'];

    protected $hidden = ['created_at','updated_at'];

    protected $casts =[
      'plan_value'=>'float'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
