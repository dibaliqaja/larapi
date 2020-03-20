<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Cities;

class Provinces extends Model
{
    use LogsActivity;

    protected $fillable = ['province_code','province_name'];

    protected static $logAttributes = ['province_code','province_name'];
}
