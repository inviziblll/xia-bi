<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = true;

    protected $fillable = [
        'name','description'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function city()
    {
        return $this->hasMany('App\City');
    }
}

