<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JailFacility extends Model
{
    public $timestamps = true;

    protected $table = 'jail_facility';

    protected $fillable = [
        'name', 'region_c', 'province_c', 'city_c', 'status'
    ];
}
