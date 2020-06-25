<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    use DateTimeMutatorsTrait;

    protected $fillable = ['client_id', 'number','date_from','date_to','deleted_at','row_id'];

    protected $hidden = ['created_at','updated_at','deleted_at'];




    protected $casts = [
        'client_id'=>'integer'
    ];


    public function client(){
        return $this->belongsTo(Client::class);
    }
}
