<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Areas extends Model
{
    use LogsActivity;

    protected $fillable = ['province_code','city_code','area_code','area_name'];

    protected static $logAttributes = ['province_code','city_code','area_code','area_name'];
}
