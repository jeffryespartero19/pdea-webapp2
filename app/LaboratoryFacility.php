<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryFacility extends Model
{
    public $timestamps = true;

    protected $table = 'laboratory_facility';

    protected $fillable = [
        'name', 'region_c', 'province_c', 'city_c','status'
    ];
}
