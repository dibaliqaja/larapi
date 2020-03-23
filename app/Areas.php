<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $fillable = ['province_code','city_code','area_code','area_name'];
}
