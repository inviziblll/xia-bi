<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = 'discounts';

    protected $fillable = ['name','value','description', 'row_id', 'pivot'];

    protected $hidden = ['created_at','updated_at', 'deleted_at', 'pivot', 'row_id'];



    public function checkDiscounts(){
        return $this->hasMany(CheckDiscount::class);
    }
}
