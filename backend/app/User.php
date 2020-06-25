<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User - модель для сущности User
 * связана с таблицей users
 */

class User extends Authenticatable implements JWTSubject
{
    use DateTimeMutatorsTrait;
    use Notifiable;

    public $timestamps = true;

    /**
     * обязательные поля при создании записи
     */
    protected $fillable = [
         'name', 'email','password'
    ];


    /**
     * скрытые поля
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'row_id', 'sys_role_id','password'
    ];



    /**
     *  методы для работы со связанными моделями
     */

    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'shop_shifts', 'user_id', 'role_id');

    }

    public function shops()
    {
        return $this->belongsToMany('App\Shop', 'shop_shifts')->withPivot(['shift_id']);

    }

    public function report_list(){
        return $this->hasMany('\App\ReportList', 'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}

