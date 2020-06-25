<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ShopCashCollectionsFactDetail extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = 'shop_cash_collection_fact_details';

    protected $fillable = ['shop_cash_collection_id','date','fact_value','deleted_at'];

    protected $hidden = ['created_at','updated_at'];


    public function shopCashCollection(){
        return $this->belongsTo(ShopCashCollection::class);
    }
}
