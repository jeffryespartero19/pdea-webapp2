<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = true;

    protected $table = 'province';

    protected $fillable = [
        'province_c', 'province_m', 'region_c', 'status',
    ];
}
