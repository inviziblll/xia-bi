<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{

    use DateTimeMutatorsTrait;

    public $timestamps = false;



    protected $fillable = [
        'name', 'const_type', 'description'
    ];


    protected $hidden = [
        // 'created_at', 'updated_at', 'deleted_at'
    ];




    public function fileLogs(){
        return $this->hasMany(FileLog::class,'file_type_id');
    }
}
