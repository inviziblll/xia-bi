<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use DateTimeMutatorsTrait;
    use \Staudenmeir\EloquentParamLimitFix\ParamLimitFix;

    public $timestamps = true;

    protected $fillable = [
        'product_group_id', 'product_type_id', 'product_brand_id', 'measure_type_id', 'sku', 'name', 'full_name', 'description'
   ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

    protected $casts = [
        'product_group_id'=>'integer',
        'product_type_id'=>'integer',
        'product_brand_id'=>'integer',
        'measure_type_id'=>'integer'
    ];


    public function remains(){

        return $this->hasMany(ProductRemain::class,"product_id");

    }

    public function productgroupproduct(){

        return $this->hasMany(ProductGroupProduts::class,'product_id');

    }


    public function groups(){
        return $this->belongsToMany(ProductGroup::class,'product_group_products','product_id','product_group_id');
    }

    public function setFirstNameAttribute($value="groups")
    {
        $this->attributes['productgroupproduct'] = strtolower($value);
    }


    /**
     * function run while we're deleting a product,
     * his main purpose is to deteach all the relationships before the deteleting action
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function(Product $product) {
            $product->groups()->detach();

        });
    }
}
