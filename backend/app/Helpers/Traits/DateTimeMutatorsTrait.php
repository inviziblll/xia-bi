<?php
namespace App\Helpers\Traits;
use Carbon\Carbon;
trait DateTimeMutatorsTrait
{



    public function fromDateTime($value)
    {
        return null;
    }

    public function getDateFormat()
    {
        return config('app.datetime_format');
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat(config('app.datetime_format'), $value)->timezone(config('app.timezone'));
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromFormat(config('app.datetime_format'), $value)->timezone(config('app.timezone'));
    }
    public function getDeletedAtAttribute($value)
    {
        return Carbon::createFromFormat(config('app.datetime_format'), $value)->timezone(config('app.timezone'));
    }
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::createFromFormat(config('app.datetime_format'),
            $value)->timezone(config('app.timezone'))->__toString();
    }
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = Carbon::createFromFormat(config('app.datetime_format'),
            $value)->timezone(config('app.timezone'))->__toString();
    }
    public function setDeletedAtAttribute($value)
    {
        $this->attributes['deleted_at'] = Carbon::createFromFormat(config('app.datetime_format'),
            $value)->timezone(config('app.timezone'))->__toString();
    }
}