<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreopsArea extends Model
{
    public $timestamps = true;

    protected $table = 'preops_area';

    protected $fillable = [
        'preops_number', 'type', 'area'
    ];
}
