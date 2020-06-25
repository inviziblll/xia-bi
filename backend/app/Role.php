<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use DateTimeMutatorsTrait;

    protected $fillable = [
        'name', 'description'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

//    public function user()
//    {
//        return $this->belongsToMany('App\User');
//    }

    public function user()
    {
        return $this->belongsToMany('App\Role', 'shop_shifts',  'role_id', 'user_id');

    }
}
