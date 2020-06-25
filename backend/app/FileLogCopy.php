<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class FileLogCopy extends Model
{
    use DateTimeMutatorsTrait;

    protected $table = "file_logs_copy";
    public $timestamps = true;

    protected $primaryKey = "id";

    protected $fillable = [
        'file_name', 'path', 'status', 'description', 'file_type_id', 'original_file_name', 'upload_date', 'parse_date'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $casts = [
        'file_type_id'=>'integer',
        'status' => 'integer'
    ];



    public function fileType()
    {
        return $this->belongsTo('App\FileType');
    }
}

