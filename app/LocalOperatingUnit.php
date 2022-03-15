<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalOperatingUnit extends Model
{
    public $timestamps = true;

    protected $table = 'local_operating_unit';

    protected $fillable = [
        'name', 'operating_unit_id', 'region_c', 'status',
    ];
}
