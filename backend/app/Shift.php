<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Eloquence;

class Shift extends Model
{

    use DateTimeMutatorsTrait;

    use Eloquence, Mappable;

    protected $table = "Shift";

    protected $primaryKey = "ShiftId";

    public $timestamps = false;

    protected $maps = [
        'id'=>'ShiftId',
        "code"=> "Code",
        "name"=> "Name",
        "hour_from"=> "HourFrom",
        "hour_to"=> "HourTo",
    ];

    protected $fillable = [
        'Code', 'Name', 'HourFrom', 'HourTo'
    ];

    protected $hidden = [
        "Code",
        "Name",
        "HourFrom",
        "HourTo",
        "ShiftId"
    ];

    protected $appends = [
        'id',
        "code",
        "name",
        "hour_from",
        "hour_to"
];



    public function shop() {
        return $this->hasMany(Shop::class);
    }
}
