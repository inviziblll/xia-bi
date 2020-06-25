<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    use DateTimeMutatorsTrait;

    protected $fillable = ['name', 'name','sex','birth','email','phone','description','deleted_ad','row_id'];

    protected $hidden = ['created_at','updated_at','deleted_at','row_id'];


    public function cards(){
        return $this->hasMany(Card::class);
    }
}
