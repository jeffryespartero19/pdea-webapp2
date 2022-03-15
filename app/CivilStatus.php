<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CivilStatus extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name', 'active'
    ];
}
