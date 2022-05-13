<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficerPosition extends Model
{
    public $timestamps = true;

    protected $table = 'officer_position';

    protected $fillable = [
        'name', 'status'
    ];
}
