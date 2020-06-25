<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class CheckDetail extends Model
{

    use DateTimeMutatorsTrait;
    public $timestamps = true;

    protected $fillable = [

        'check_header_id','check_type_id','product_id', 'user_id','line_number', 'count', 'price',
        'amount','discount_auto','discount_manual','bonus','nds','deleted_at','row_id'

    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id','bonus_service'
    ];

    protected $casts = [
        'check_header_id'=>'integer',
        'product_id'=>'integer',
        'user_id'=>'integer',
        'check_type_id'=>'integer',
        'count'=>'integer',
        'amount'=>'float',
        'price'=>'float',
        'discount'=>'float',
        'bonus'=>'float',
        'discount_percent'=>'float'
    ];
    
    public function checkheader(){

        return $this->belongsTo(CheckHeader::class,"check_header_id");

    }

    public function checktype(){

        return $this->belongsTo(CheckType::class,'check_type_id');

    }

    public function card(){
        return $this->belongsTo(Card::class);
    }

    public function product(){

        return $this->belongsTo(Product::class, 'product_id');

    }

    public function user(){

        return $this->belongsTo(User::class, 'user_id');

    }
}
