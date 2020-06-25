<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

    use DateTimeMutatorsTrait;

    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *

     *
     * @var array
     */

    public $timestamps = true;

    protected $fillable = [
         //'name', 'description','created_at', 'updated_at', 'deleted_at', 'user_id'
        'name', 'description', 'user_id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'row_id', 'sys_role_id','password'
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function user()
    {
        return $this->hasMany('App\User');
    }

}

