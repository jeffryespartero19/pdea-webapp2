<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = true;

    protected $table = 'city';

    protected $fillable = [
        'city_c', 'city_m', 'province_c', 'status',
    ];
}
