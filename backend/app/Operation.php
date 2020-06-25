<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = false;


    protected $fillable = [
        'name', 'description'
    ];

//    protected $hidden = [
//        'created_at', 'updated_at', 'deleted_at'
//    ];


}
