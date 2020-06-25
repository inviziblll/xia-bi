<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class FileStatus extends Model
{

    use DateTimeMutatorsTrait;

    protected $fillable = ['code','name'];

    protected $table = 'file_status';


    public function fileLogs(){

        return $this->hasMany(FileLog::class);
    }
}
