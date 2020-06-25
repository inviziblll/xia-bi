<?php

namespace App;

use App\Helpers\Traits\DateTimeMutatorsTrait;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use DateTimeMutatorsTrait;
}
