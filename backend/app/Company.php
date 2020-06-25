<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use DateTimeMutatorsTrait;

    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *

     *
     * @var array
     */

    protected $fillable = [
        'name', 'prefix', 'description'
    ];

    protected $hidden = [
        'row_id',  'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

//    public function shop() {
//        return $this->hasMany('App\Shop');
//    }

}
