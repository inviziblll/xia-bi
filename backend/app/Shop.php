<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use DateTimeMutatorsTrait;

    public $timestamps = true;

    protected $fillable = [
        'company_id','city_id','shop_type_id','division_id','warehouse_from_id','warehouse_to_id','name','encashment','description'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'row_id'
    ];

    protected $casts = [
        'company_id' => 'integer',
        'city_id' => 'integer',
        'shop_type_id' => 'integer',
        'division_id' => 'integer',
        'warehouse_from_id' => 'integer',
        'warehouse_to_id' => 'integer',
        'encashment'=>'float'
    ];


    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function visitlogs(){
        return $this->hasMany(VisitLog::class);
    }

    public function staffPlans(){
        return $this->hasMany('App\StaffPlan');
    }
}
