<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class ShopShift extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = "StaffPlan";
    //

    //    public function user()
    //    {
    //        return $this->hasMany('App\User');
    //    }
    public $timestamps = true;


    // public $table = 'shop_shifts';

    // 'date' = '2018-04-12 10:25:15.000'
    protected $fillable = [
        'shop_id','user_id', 'shift_id', 'date', 'role_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'shop_id'=>'integer',
        'user_id'=>'integer',
        'shift_id'=>'integer',
        'role_id'=>'integer'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shops(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function shifts(){
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function roles(){
        return $this->belongsTo(Role::class,'role_id');
    }


}
