<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class FileLog extends Model
{

    use DateTimeMutatorsTrait;

    protected $table = "file_logs";

//    public $timestamps = true;
//
//    protected $primaryKey = "id";

    protected $columns = array('file_name', 'path', 'file_status_id', 'description', 'file_type_id', 'original_file_name', 'upload_date', 'parse_date','content');

    protected $fillable = [
        'file_name', 'path', 'file_status_id', 'description', 'file_type_id', 'original_file_name', 'upload_date', 'parse_date', 'content'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $casts = [
        'file_type_id'=>'integer',
        'file_status_id' => 'integer'
    ];



    public function fileType()
    {
        return $this->belongsTo(FileType::class, 'file_type_id');
    }


    public function fileStatus(){

        return $this->belongsTo(FileStatus::class, 'file_status_id');

    }

     // add all columns from you table

    public function scopeExclude($query,$value = array())
    {
        return $query->select( array_diff( $this->columns,(array) $value) );
    }
}

