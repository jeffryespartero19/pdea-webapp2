<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = true;

    protected $table = 'region';

    protected $fillable = [
        'region_c', 'region_m', 'abbreviation', 'region_sort', 'status',
    ];
}
