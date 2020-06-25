<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductGroupProduts extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = "product_group_products";



    protected $fillable = ['product_group_id','product_id'];

    protected $hidden = ['product_group_id','product_id'];


    public function productgroup(){

        return $this->belongsTo('\App\ProductGroup','product_group_id');
    }

    public function product(){

        return $this->belongsTo('\App\Product','product_id');
    }


}
