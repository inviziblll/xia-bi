<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ShopType extends Model
{
    use DateTimeMutatorsTrait;

    public $table = 'shop_types';

    public $timestamps = true;


    protected $fillable = [
        'name', 'description'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function shop()
    {
        return $this->hasMany('App\Shop');
    }

}
