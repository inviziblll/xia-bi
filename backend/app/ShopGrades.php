<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ShopGrades extends Model
{
    use DateTimeMutatorsTrait;

    protected $table = 'shop_grades';

    protected $fillable = ['shop_id','date','tt_bonus', 'tt_seperate'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'shop_id'=>'integer'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class, "shop_id");
    }
}
