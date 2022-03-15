<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingUnit extends Model
{
    public $timestamps = true;

    protected $table = 'operating_unit';

    protected $fillable = [
        'name', 'description', 'region_c', 'province_c', 'city_c', 'status',
    ];
}
