<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class CheckBonus extends Model
{
    use DateTimeMutatorsTrait;

    protected $fillable = [
        'check_header_id','product_id','date','bonus_count','deleted_at','row_id'
    ];

    protected $hidden = [
      'row_id','updated_at','created_at'
    ];




    public function product(){

        return $this->belongsTo(Product::class);

    }

    public function checkheader(){

        return $this->belongsTo(CheckHeader::class, 'check_header_id');

    }
}
