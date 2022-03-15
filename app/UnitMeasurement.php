<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitMeasurement extends Model
{
    public $timestamps = true;

    protected $table = 'unit_measurement';

    protected $fillable = [
        'name', 'status'
    ];
}
