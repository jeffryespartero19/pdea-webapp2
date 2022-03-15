<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $timestamps = true;

    protected $table = 'position';

    protected $fillable = [
        'name', 'status'
    ];
}
