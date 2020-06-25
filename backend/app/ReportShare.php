<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use App\Scope\ReportScope;
use Illuminate\Database\Eloquent\Model;

class ReportShare extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = "report_shares";
    protected $fillable = ['user_id', 'user_from','report_id'];
//
//    protected $casts = [
//        'user_id'=>'integer',
//        'report_id'=>'integer',
//        'user_from'=>'integer',
//    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function report()
    {
        return $this->belongsTo('App\ReportList', 'report_id');
    }


    protected static function boot()
    {
        parent::boot();

        // get all reports where user_id == current user_id of class User
        static::addGlobalScope(new ReportScope('user_from'));
    }
}
