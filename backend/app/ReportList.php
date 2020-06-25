<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use App\Scope\ReportScope;
use Illuminate\Database\Eloquent\Model;

class ReportList extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = "report_list";

//    public $timestamps = false;
    protected $fillable = ['title','cube','data','user_id'];

    protected $hidden = [
        'created_at', 'updated_at', 'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }


}
