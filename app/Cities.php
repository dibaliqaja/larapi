<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Cities extends Model
{
    use LogsActivity;

    protected $fillable = ['province_code','city_code','city_name'];

    protected static $logAttributes = ['province_code','city_code','city_name'];
}
