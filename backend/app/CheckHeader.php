<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class CheckHeader extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = true;

    protected $fillable = [
        'check_operation_id', 'cash_desk_id', 'card_id', 'date', 'change_number', 'check_number', 'check_status','deleted_at','row_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

    protected $casts = [
        'check_type_id'=>'integer',
        'check_operation_id'=>'integer',
        'cash_desk_id'=>'integer',
         'change_number'=>'string',
        'check_number'=>'string',
        'check_status'=>'integer'
    ];



    public function cashdesk(){

        return $this->belongsTo(CashDesk::class,'cash_desk_id');
    }

    public function checkoperation(){

        return $this->belongsTo(CheckOperation::class ,'check_operation_id');

    }

    public function card(){
        return $this->belongsTo(Card::class);
    }

    public function checkdetail(){

        return $this->hasMany(CheckDetail::class);

    }

    public function discounts(){
        return $this->belongsToMany(Discount::class,'check_discounts','check_header_id','discount_id');
    }


    protected static function boot() {
        parent::boot();

        static::deleting(function( CheckHeader $checkdeheader) {
            $checkdeheader->checkdetail()->delete();

        });
    }
}
