<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class CheckDiscount extends Model
{

    use DateTimeMutatorsTrait;
    protected $table = 'check_discounts';
    protected $fillable = ['check_header_id','discount_id'];
    protected $hidden = ['created_at','updated_at'];
}
